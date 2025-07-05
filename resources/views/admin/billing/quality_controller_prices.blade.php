@extends('layouts.admin_layout')
@section('title', 'Quality Controller Pricing')
@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Quality Controller Pricing</h1>
                </div>
            </div>
        </div>
    </div>
    <section class="content">
        <div class="container-fluid">
            <div class="card card-secondary">
                <div class="card-header">
                    <h3 class="card-title">Select Quality Controller</h3>
                </div>
                <div class="card-body">
                    <div class="form-group d-flex align-items-end">
                        <div style="flex:1;">
                            <label for="qcSelect">Quality Controller</label>
                            <select id="qcSelect" class="form-control">
                                <option value="">-- Select --</option>
                            </select>
                        </div>
                        <button id="save-qc-prices" class="btn btn-success ml-3 mb-1" style="height:38px;display:none;">Save</button>
                    </div>
                </div>
            </div>
            <div id="grouped-qc-prices" class="row mt-4"></div>
        </div>
    </section>
</div>
@endsection
@section('extra_js')
@parent
<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).ready(function() {
    // Fetch QCs
    $.getJSON('/admin/billing/quality-controllers-list', function(data) {
        data.forEach(function(qc) {
            $('#qcSelect').append(`<option value="${qc.id}">${qc.name}</option>`);
        });
    });
    $('#save-qc-prices').hide();
    $('#qcSelect').off('change').on('change', function() {
        var qcId = $(this).val();
        if (!qcId) {
            $('#grouped-qc-prices').html('');
            $('#save-qc-prices').hide();
            return;
        }
        $.ajax({
            url: '/admin/billing/quality-controller-prices/data',
            type: 'GET',
            data: { user_id: qcId },
            dataType: 'json',
            success: function(data) {
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
                $('#grouped-qc-prices').html(html);
                $('#save-qc-prices').show();
            },
            error: function(xhr) {
                $('#grouped-qc-prices').html('<div class="col-12 text-danger">Failed to load prices.</div>');
                $('#save-qc-prices').hide();
            }
        });
    });
    $('#save-qc-prices').off('click').on('click', function() {
        var qcId = $('#qcSelect').val();
        var prices = {};
        $('.group-price-input').each(function() {
            prices[$(this).data('group-id')] = $(this).val();
        });
        $.ajax({
            url: '/admin/billing/quality-controller-prices',
            type: 'POST',
            data: {
                user_id: qcId,
                prices: prices,
                _token: '{{ csrf_token() }}'
            },
            success: function(resp) {
                if (resp.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: 'Prices updated successfully!',
                        showConfirmButton: true
                    });
                }
            }
        });
    });
});
</script>
@endsection
