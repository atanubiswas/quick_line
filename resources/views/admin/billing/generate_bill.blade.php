@extends('layouts.admin_layout')
@section('title', 'Generate Bill')
@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Generate Bill</h1>
                </div>
            </div>
        </div>
    </div>
    <section class="content">
        <div class="container-fluid">
            <div class="card card-secondary">
                <div class="card-header">
                    <h3 class="card-title">Bill Filters</h3>
                </div>
                <div class="card-body">
                    <form id="bill-filter-form" class="form-row align-items-end">
                        <div class="form-group col-md-4">
                            <label for="centre_select">Centre</label>
                            <select id="centre_select" name="centre_id" class="form-control">
                                <option value="">-- Select Centre --</option>
                                @foreach($centres as $centre)
                                    <option value="{{ $centre->id }}">{{ $centre->lab_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="start_date">Start Date</label>
                            <input type="date" id="start_date" name="start_date" class="form-control" value="{{ date('Y-m-d') }}" max="{{ date('Y-m-d') }}">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="end_date">End Date</label>
                            <input type="date" id="end_date" name="end_date" class="form-control" value="{{ date('Y-m-d') }}" max="{{ date('Y-m-d') }}">
                        </div>
                        <div class="form-group col-md-2">
                            <button type="button" id="filter-bill-btn" class="btn btn-primary w-100">Generate Bill</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card mt-4">
                <div class="card-header">
                    <h3 class="card-title">Bill Data</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <div id="bill-loading" style="display:none;text-align:center;padding:30px;">
                            <span class="spinner-border spinner-border-sm text-primary" role="status" aria-hidden="true"></span>
                            <span>Generating...</span>
                        </div>
                        <table class="table table-bordered table-hover" id="bill_datatable">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Patient ID</th>
                                    <th>Patient Name</th>
                                    <th>Gender/Age</th>
                                    <th>Modality</th>
                                    <th>Study Type</th>
                                    <th>Date</th>
                                    <th>Reported On</th>
                                    <th>Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Data will be loaded via AJAX -->
                            </tbody>
                        </table>
                    </div>
                    <!-- Download Excel Button -->
                    <div id="excel-btn-container" style="margin-top: 20px; display: none;">
                        <button id="download-excel-btn" class="btn btn-success" style="background-color: #28a745; border-color: #28a745;">
                            Download Excel
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
@section('extra_js')
@parent
<script src="{{asset('/js/export-excel.js')}}"></script>
<script>
$(document).ready(function() {
    // Set min for end_date to start_date
    $('#start_date').on('change', function() {
        var startDate = $(this).val();
        var endDate = $('#end_date').val();
        if (startDate > endDate) {
            $('#end_date').val(startDate);
        }
        $('#end_date').attr('min', startDate);
    });
    $('#end_date').attr('min', $('#start_date').val());
    // Filter button click
    $('#filter-bill-btn').on('click', function() {
        var centreId = $('#centre_select').val();
        var startDate = $('#start_date').val();
        var endDate = $('#end_date').val();
        if (!centreId) {
            Swal.fire({
                icon: 'warning',
                title: 'Validation Error',
                text: 'Please select a Centre.'
            });
            return;
        }
        if (!startDate) {
            Swal.fire({
                icon: 'warning',
                title: 'Validation Error',
                text: 'Please select a Start Date.'
            });
            return;
        }
        if (!endDate) {
            Swal.fire({
                icon: 'warning',
                title: 'Validation Error',
                text: 'Please select an End Date.'
            });
            return;
        }
        $(this).data('original-text', $(this).html());
        $(this).prop('disabled', true).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Generating');
        fetchBillData();
    });
    function fetchBillData() {
        var centreId = $('#centre_select').val();
        var startDate = $('#start_date').val();
        var endDate = $('#end_date').val();
        $('#bill-loading').show();
        $('#bill_datatable').hide();
        $('#excel-btn-container').hide(); // Hide Excel button while loading
        $.ajax({
            url: "{{ route('admin.billing.generate_bill_data') }}",
            type: 'GET',
            data: {
                centre_id: centreId,
                start_date: startDate,
                end_date: endDate
            },
            success: function(data) {
                $('#bill-loading').hide();
                $('#bill_datatable').show();
                $('#filter-bill-btn').prop('disabled', false).html($('#filter-bill-btn').data('original-text'));
                if (data.error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Missing Price',
                        text: data.error
                    });
                    $('#bill_datatable tbody').html('<tr><td colspan="9" class="text-center">No data found.</td></tr>');
                    $('#total_amount_row').remove();
                    $('#excel-btn-container').hide(); // Hide Excel button if error
                    return;
                }
                var tbody = '';
                if (!data.data || data.data.length === 0) {
                    tbody = '<tr><td colspan="9" class="text-center">No data found.</td></tr>';
                    $('#excel-btn-container').hide(); // Hide Excel button if no data
                } else {
                    data.data.forEach(function(row, idx) {
                        tbody += '<tr>' +
                            '<td>' + (idx+1) + '</td>' +
                            '<td>' + row.patient_id + '</td>' +
                            '<td>' + row.patient_name + '</td>' +
                            '<td>' + row.gender_age + '</td>' +
                            '<td>' + row.modality + '</td>' +
                            '<td>' + row.study_type + '</td>' +
                            '<td>' + row.date + '</td>' +
                            '<td>' + row.reported_on + '</td>' +
                            '<td>' + (parseFloat(row.amount).toFixed(2)) + '</td>' +
                            '</tr>';
                    });
                    tbody += '<tr id="total_amount_row">' +
                        '<td colspan="8" class="text-right font-weight-bold">Total Amount</td>' +
                        '<td class="font-weight-bold">' +
                        '<span style="font-weight:bold;">&#8377; ' + (parseFloat(data.total_amount).toFixed(2)) + '</span>' +
                        '</td>' +
                        '</tr>';
                    $('#excel-btn-container').show(); // Show Excel button if data exists
                }
                $('#bill_datatable tbody').html(tbody);
            },
            error: function() {
                $('#bill-loading').hide();
                $('#bill_datatable').show();
                $('#filter-bill-btn').prop('disabled', false).html($('#filter-bill-btn').data('original-text'));
                $('#excel-btn-container').hide(); // Hide Excel button on error
            }
        });
    }
    // Download Excel button click
    $('#download-excel-btn').on('click', function() {
        var $btn = $(this);
        var originalText = $btn.html();
        $btn.prop('disabled', true).html('Downloading...');
        setTimeout(function() {
            exportTableToExcel('bill_datatable', '');
            $btn.prop('disabled', false).html(originalText);
        }, 100);
    });
    // Initial load
    fetchBillData();
});
</script>
@endsection
