@extends('layouts.admin_layout')
@section('title', 'Center Study Type Prices')
@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Center Wise Priceing</h1>
                </div>
            </div>
        </div>
    </div>
    <section class="content">
        <div class="container-fluid">
            <div class="card card-secondary">
                <div class="card-header">
                    <h3 class="card-title">Select Center</h3>
                </div>
                <div class="card-body">
                    <div class="form-group d-flex align-items-end">
                        <div style="flex:1;">
                            <label for="center_select">Center</label>
                            <select id="center_select" class="form-control">
                                <option value="">-- Select Center --</option>
                                @foreach($centers as $center)
                                    <option value="{{ $center->id }}">{{ $center->lab_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button id="save-center-prices" class="btn btn-success ml-3 mb-1" style="height:38px;display:none;">Save</button>
                    </div>
                </div>
            </div>
            <div id="grouped-dropzones" class="row mt-4"></div>
        </div>
    </section>
</div>
@endsection
@section('extra_js')
@parent
<!-- jQuery UI for drag and drop -->
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
<script>
$(document).ready(function() {
    $('#save-center-prices').hide();
    $('#center_select').on('change', function() {
        var centerId = $(this).val();
        if (!centerId) {
            $('#grouped-dropzones').html('');
            $('#save-center-prices').hide();
            return;
        }
        $.getJSON("{{ route('admin.billing.get_center_prices') }}", { center_id: centerId }, function(data) {
            // Group study types by price_group
            var groups = {};
            data.forEach(function(row) {
                if (!groups[row.price_group_id]) {
                    groups[row.price_group_id] = {
                        group_name: row.price_group_name,
                        study_types: [],
                        center_prices: [] // collect center prices for this group
                    };
                }
                groups[row.price_group_id].study_types.push(row);
                // If price is from study_center_prices (i.e., differs from default), collect it
                if (row.price !== row.default_price) {
                    groups[row.price_group_id].center_prices.push(row.price);
                }
            });
            // Now set group.default_price for each group
            Object.keys(groups).forEach(function(groupId) {
                var group = groups[groupId];
                if (group.center_prices.length > 0) {
                    group.default_price = group.center_prices[0]; // first value from study_center_prices
                } else if (group.study_types.length > 0) {
                    group.default_price = group.study_types[0].default_price; // fallback to study_type default
                } else {
                    group.default_price = 0;
                }
            });
            var html = '';
            Object.keys(groups).forEach(function(groupId) {
                var group = groups[groupId];
                html += '<div class="col-md-3">';
                html += '<div class="card mb-3">';
                html += '<div class="card-header bg-secondary text-white">';
                html += '<div class="d-flex justify-content-between align-items-center">';
                html += '<span>' + group.group_name + '</span>';
                html += '<input type="number" step="0.01" min="0" class="form-control form-control-sm w-50 group-price-input" data-group-id="' + groupId + '" value="' + group.default_price + '" style="max-width:120px;">';
                html += '</div></div>';
                html += '<div class="card-body">';
                html += '<ul class="list-group dropzone" data-group-id="' + groupId + '" style="min-height:100px;">';
                group.study_types.forEach(function(st) {
                    html += '<li class="list-group-item draggable" data-study-type-id="' + st.study_type_id + '">' + st.study_type_name + ' <span class="badge badge-info float-right">' + st.price + '</span></li>';
                });
                html += '</ul>';
                html += '</div></div></div>';
            });
            $('#grouped-dropzones').html(html);
            $('#save-center-prices').show();
            // Make dropzones sortable and connected
            $('.dropzone').sortable({
                connectWith: '.dropzone',
                placeholder: 'ui-state-highlight',
                items: '> .draggable',
                forcePlaceholderSize: true
            }).disableSelection();

            // Save button click handler
            $('#save-center-prices').off('click').on('click', function() {
                var centerId = $('#center_select').val();
                var prices = [];
                $('.dropzone').each(function() {
                    var groupId = $(this).data('group-id');
                    var groupPrice = $(this).closest('.card').find('.group-price-input').val();
                    $(this).find('.draggable').each(function() {
                        prices.push({
                            study_type_id: $(this).data('study-type-id'),
                            price: groupPrice, // Use the group price input value
                            price_group_id: groupId,
                        });
                    });
                });
                $.ajax({
                    url: "{{ route('admin.billing.update_center_prices') }}",
                    type: 'POST',
                    data: {
                        center_id: centerId,
                        prices: prices,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(resp) {
                        if (resp.success) {
                            printSuccessMsg('Prices updated successfully!');
                        }
                    }
                });
            });
        });
    });
});
</script>
@endsection
