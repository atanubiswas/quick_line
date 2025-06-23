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
                        <div class="form-group col-md-3">
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
                        <div class="form-group col-md-3 d-flex align-items-center">
                            <input type="checkbox" id="previous-month-checkbox" style="margin-right:5px;">
                            <label for="previous-month-checkbox" style="margin-bottom:0;margin-right:10px;">Previous Month</label>
                            <button type="button" id="filter-bill-btn" class="btn btn-primary">Generate Bill</button>
                            <button type="button" id="view-saved-bills-btn" class="btn btn-info ml-2">Saved Bills</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card mt-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title mb-0">Bill Data</h3>
                    <div class="flex-grow-1"></div>
                    <button id="save-bill-btn" class="btn btn-warning ml-auto" style="display:none;">Save Bill</button>
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
                    <!-- Download Excel and PDF Buttons -->
                    <div id="excel-btn-container" style="margin-top: 20px; display: none;">
                        <button id="download-excel-btn" class="btn btn-success" style="background-color: #28a745; border-color: #28a745;">
                            Download Excel
                        </button>
                        <form id="pdf-export-form" method="GET" action="{{ route('admin.billing.export_pdf') }}" style="display:inline;">
                            <input type="hidden" name="centre_id" id="pdf_centre_id">
                            <input type="hidden" name="start_date" id="pdf_start_date">
                            <input type="hidden" name="end_date" id="pdf_end_date">
                            <button type="submit" id="download-pdf-btn" class="btn btn-success ml-2" style="background-color: #28a745; border-color: #28a745;">
                                Download PDF
                            </button>
                        </form>
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
                    tbody += '<tr id="total_summary_row">' +
                        '<td colspan="3" style="background:#e6f2ff;font-size:14px;font-weight:bold;color:#1a237e;">Total Number of Study</td>' +
                        '<td class="text-right font-weight-bold" style="background:#e6f2ff;font-size:14px;font-weight:bold;color:#1a237e;">' + data.data.length + '</td>' +
                        '<td colspan="2" style="background:#e6f2ff;"></td>' +
                        '<td colspan="2" style="background:#e6f2ff;font-size:14px;font-weight:bold;color:#1a237e;">Total Amount</td>' +
                        '<td style="background:#e6f2ff;font-size:14px;font-weight:bold;color:#1a237e;"><span class="d-block mt-1" style="font-weight:bold;">' + (data.total_amount ? parseFloat(data.total_amount).toFixed(2) : '0.00') + '</span></td>' +
                        '</tr>';
                    $('#excel-btn-container').show(); // Show Excel button if data exists
                    $('#save-bill-btn').show(); // Show Save Bill button if data exists
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
    // Download PDF button click (server-side)
    $('#download-pdf-btn').on('click', function(e) {
        // Set hidden fields to current filter values
        $('#pdf_centre_id').val($('#centre_select').val());
        $('#pdf_start_date').val($('#start_date').val());
        $('#pdf_end_date').val($('#end_date').val());
        // Allow form to submit
    });
    // Previous Month checkbox logic
    var prevStartDate = '';
    var prevEndDate = '';
    $('#previous-month-checkbox').on('change', function() {
        if ($(this).is(':checked')) {
            prevStartDate = $('#start_date').val();
            prevEndDate = $('#end_date').val();
            var now = new Date();
            var prevMonth = new Date(now.getFullYear(), now.getMonth() - 1, 1);
            var prevMonthStart = new Date(prevMonth.getFullYear(), prevMonth.getMonth(), 1);
            var prevMonthEnd = new Date(prevMonth.getFullYear(), prevMonth.getMonth() + 1, 0);
            var pad = function(n) { return n < 10 ? '0' + n : n; };
            var startStr = prevMonthStart.getFullYear() + '-' + pad(prevMonthStart.getMonth() + 1) + '-' + pad(prevMonthStart.getDate());
            var endStr = prevMonthEnd.getFullYear() + '-' + pad(prevMonthEnd.getMonth() + 1) + '-' + pad(prevMonthEnd.getDate());
            $('#start_date').val(startStr);
            $('#end_date').val(endStr);
            $('#end_date').attr('min', startStr);
        } else {
            if (prevStartDate) $('#start_date').val(prevStartDate);
            if (prevEndDate) $('#end_date').val(prevEndDate);
            $('#end_date').attr('min', $('#start_date').val());
        }
    });
    // Save Bill button click
    $('#save-bill-btn').off('click').on('click', function() {
        var $btn = $(this);
        $btn.prop('disabled', true).html('Saving...');
        var centreId = $('#centre_select').val();
        var startDate = $('#start_date').val();
        var endDate = $('#end_date').val();
        var totalAmount = 0;
        var totalStudy = 0;
        var billData = [];
        $('#bill_datatable tbody tr').each(function() {
            var $cells = $(this).find('td');
            if ($cells.length === 9 && !$cells.parent().attr('id')) {
                billData.push({
                    patient_id: $cells.eq(1).text(),
                    patient_name: $cells.eq(2).text(),
                    gender_age: $cells.eq(3).text(),
                    modality: $cells.eq(4).text(),
                    study_type: $cells.eq(5).text(),
                    date: $cells.eq(6).text(),
                    reported_on: $cells.eq(7).text(),
                    amount: parseFloat($cells.eq(8).text())
                });
                totalAmount += parseFloat($cells.eq(8).text());
                totalStudy++;
            }
        });
        if (billData.length === 0) {
            Swal.fire({ icon: 'warning', title: 'No Data', text: 'No bill data to save.' });
            $btn.prop('disabled', false).html('Save Bill');
            return;
        }
        $.ajax({
            url: "{{ route('admin.billing.save_bill') }}",
            type: 'POST',
            data: {
                centre_id: centreId,
                start_date: startDate,
                end_date: endDate,
                total_amount: totalAmount,
                total_study: totalStudy,
                bill_data: billData,
                _token: '{{ csrf_token() }}'
            },
            success: function(resp) {
                if (resp.success) {
                    Swal.fire({ icon: 'success', title: 'Saved', text: 'Bill saved successfully! Invoice: ' + resp.invoice_number });
                    $btn.prop('disabled', false).html('Save Bill');
                } else if (resp.error) {
                    Swal.fire({ icon: 'error', title: 'Error', text: resp.error });
                    $btn.prop('disabled', false).html('Save Bill');
                }
            },
            error: function(xhr) {
                if (xhr.status === 409 && xhr.responseJSON && xhr.responseJSON.error) {
                    Swal.fire({ icon: 'warning', title: 'Duplicate', text: xhr.responseJSON.error });
                } else {
                    Swal.fire({ icon: 'error', title: 'Error', text: 'Failed to save bill.' });
                }
                $btn.prop('disabled', false).html('Save Bill');
            }
        });
    });
    // View Saved Bills button click
    $('#view-saved-bills-btn').on('click', function() {
        window.location.href = "{{ route('admin.billing.saved_bills') }}";
    });
    // Initial load
    fetchBillData();
});
</script>
@endsection
