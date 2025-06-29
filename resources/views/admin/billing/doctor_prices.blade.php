@extends('layouts.admin_layout')
@section('title', 'Doctor Study Type Prices')
@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Doctor Wise Pricing</h1>
                </div>
            </div>
        </div>
    </div>
    <section class="content">
        <div class="container-fluid">
            <div class="card card-secondary">
                <div class="card-header">
                    <h3 class="card-title">Select Doctor</h3>
                </div>
                <div class="card-body">
                    <div class="form-group d-flex align-items-end">
                        <div style="flex:1;">
                            <label for="doctor_select">Doctor</label>
                            <select id="doctor_select" class="form-control">
                                <option value="">-- Select Doctor --</option>
                                @foreach($doctors as $doctor)
                                    <option value="{{ $doctor->id }}">{{ $doctor->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button id="save-doctor-prices" class="btn btn-success ml-3 mb-1" style="height:38px;display:none;">Save</button>
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
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
$(document).ready(function() {
    $('#doctor_select').select2({
        width: '100%',
        placeholder: '-- Select Doctor --',
        allowClear: true
    });
    $('#save-doctor-prices').hide();
    $('#doctor_select').on('change', function() {
        var doctorId = $('#doctor_select').val();
        if (!doctorId) {
            $('#grouped-dropzones').html('');
            $('#save-doctor-prices').hide();
            return;
        }
        $.getJSON("{{ route('admin.billing.get_doctor_prices') }}", { doctor_id: doctorId }, function(data) {
            var groups = {};
            data.forEach(function(row) {
                if (!groups[row.price_group_id]) {
                    groups[row.price_group_id] = {
                        group_name: row.price_group_name,
                        default_price: row.default_price,
                        price: row.price,
                    };
                }
            });
            var html = '';
            Object.keys(groups).forEach(function(groupId) {
                var group = groups[groupId];
                html += '<div class="col-md-3">';
                html += '<div class="card mb-3" style="min-height:180px;max-height:220px;overflow:hidden;">';
                html += '<div class="card-header bg-secondary text-white">';
                html += '<span>' + group.group_name + '</span>';
                html += '</div>';
                html += '<div class="card-body p-2">';
                html += '<label>Price</label>';
                html += '<input type="number" step="0.01" min="0" class="form-control form-control-sm group-price-input" data-group-id="' + groupId + '" value="' + group.price + '" style="max-width:120px;">';
                html += '<small class="text-muted">Default: ' + group.default_price + '</small>';
                html += '</div></div></div>';
            });
            $('#grouped-dropzones').html(html);
            $('#save-doctor-prices').show();
        });
    });
    $('#save-doctor-prices').off('click').on('click', function() {
        var doctorId = $('#doctor_select').val();
        var prices = [];
        $('.group-price-input').each(function() {
            prices.push({
                price_group_id: $(this).data('group-id'),
                price: $(this).val()
            });
        });
        $.ajax({
            url: "{{ route('admin.billing.update_doctor_prices') }}",
            type: 'POST',
            data: {
                doctor_id: doctorId,
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
</script>
@endsection
