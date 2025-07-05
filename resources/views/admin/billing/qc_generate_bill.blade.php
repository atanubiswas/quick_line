@extends('layouts.admin_layout')
@section('title', 'Generate QC Bill')
@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Generate Quality Controller Bill</h1>
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
                    <form id="qc-bill-filter-form" class="form-row align-items-end">
                        <div class="form-group col-md-3">
                            <label for="qc_select">Quality Controller</label>
                            <select id="qc_select" name="qc_id" class="form-control">
                                <option value="">-- Select Quality Controller --</option>
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
                            <input type="checkbox" id="qc-previous-month-checkbox" style="margin-right:5px;">
                            <label for="qc-previous-month-checkbox" style="margin-bottom:0;margin-right:10px;">Previous Month</label>
                            <button type="button" id="filter-qc-bill-btn" class="btn btn-primary">Generate Bill</button>
                            <a href="{{ route('admin.billing.saved_qc_bills') }}" class="btn btn-info ml-2" id="view-saved-qc-bills-btn">View Saved Bills</a>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card mt-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title mb-0">QC Bill Data</h3>
                    <div class="flex-grow-1"></div>
                    <button id="save-qc-bill-btn" class="btn btn-warning ml-auto" style="display:none;">Save Bill</button>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <div id="qc-bill-loading" style="display:none;text-align:center;padding:30px;">
                            <span class="spinner-border spinner-border-sm text-primary" role="status" aria-hidden="true"></span>
                            <span>Generating...</span>
                        </div>
                        <table class="table table-bordered table-hover" id="qc_bill_datatable">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Case ID</th>
                                    <th>Patient Name</th>
                                    <th>Gender/Age</th>
                                    <th>Study Type</th>
                                    <th>Date</th>
                                    <th>Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Data will be loaded via AJAX -->
                            </tbody>
                        </table>
                    </div>
                    <div id="qc-pdf-btn-container" style="margin-top: 20px; display: none;">
                        <form id="qc-pdf-export-form" method="GET" action="{{ route('admin.billing.qc_generate_bill_pdf') }}" style="display:inline;">
                            <input type="hidden" name="qc_id" id="pdf_qc_id">
                            <input type="hidden" name="start_date" id="pdf_start_date">
                            <input type="hidden" name="end_date" id="pdf_end_date">
                            <button type="submit" id="download-qc-pdf-btn" class="btn btn-success ml-2" style="background-color: #28a745; border-color: #28a745;">
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
<script>
    var qcBillDataUrl = "{{ route('admin.billing.qc_generate_bill_data') }}";
    window.saveQcBillUrl = "{{ route('admin.billing.save_qc_bill') }}";
    var getQcListUrl = "{{ route('admin.billing.qc_list') }}";
</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
$(document).ready(function() {
    // Populate QC select
    $.get(getQcListUrl, function(data) {
        var $qcSelect = $('#qc_select');
        $qcSelect.empty().append('<option value="">-- Select Quality Controller --</option>');
        data.forEach(function(qc) {
            $qcSelect.append('<option value="' + qc.id + '">' + qc.name + '</option>');
        });
    });
    $('#qc_select').select2({ width: '100%', placeholder: '-- Select Quality Controller --', allowClear: true });
    // Date logic (same as doctor)
    $('#start_date').on('change', function() {
        var startDate = $(this).val();
        var endDate = $('#end_date').val();
        if (startDate > endDate) {
            $('#end_date').val(startDate);
        }
        $('#end_date').attr('min', startDate);
    });
    $('#end_date').attr('min', $('#start_date').val());
    // Previous Month checkbox logic
    var prevStartDate = '';
    var prevEndDate = '';
    $('#qc-previous-month-checkbox').on('change', function() {
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
    // Filter button click
    $('#filter-qc-bill-btn').on('click', function() {
        var qcId = $('#qc_select').val();
        var startDate = $('#start_date').val();
        var endDate = $('#end_date').val();
        if (!qcId) {
            Swal.fire({ icon: 'warning', title: 'Validation Error', text: 'Please select a Quality Controller.' });
            return;
        }
        if (!startDate) {
            Swal.fire({ icon: 'warning', title: 'Validation Error', text: 'Please select a Start Date.' });
            return;
        }
        if (!endDate) {
            Swal.fire({ icon: 'warning', title: 'Validation Error', text: 'Please select an End Date.' });
            return;
        }
        $(this).data('original-text', $(this).html());
        $(this).prop('disabled', true).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Generating');
        fetchQcBillData();
    });
    function fetchQcBillData() {
        var qcId = $('#qc_select').val();
        var startDate = $('#start_date').val();
        var endDate = $('#end_date').val();
        $('#qc-bill-loading').show();
        $('#qc_bill_datatable').hide();
        $('#qc-pdf-btn-container').hide();
        $.ajax({
            url: qcBillDataUrl,
            type: 'GET',
            data: {
                qc_id: qcId,
                start_date: startDate,
                end_date: endDate
            },
            success: function(data) {
                $('#qc-bill-loading').hide();
                $('#qc_bill_datatable').show();
                $('#filter-qc-bill-btn').prop('disabled', false).html($('#filter-qc-bill-btn').data('original-text'));
                if (data.error) {
                    Swal.fire({ icon: 'error', title: 'Missing Price', text: data.error });
                    $('#qc_bill_datatable tbody').html('<tr><td colspan="7" class="text-center">No data found.</td></tr>');
                    $('#qc-pdf-btn-container').hide();
                    return;
                }
                var tbody = '';
                if (!data.data || data.data.length === 0) {
                    tbody = '<tr><td colspan="7" class="text-center">No data found.</td></tr>';
                    $('#save-qc-bill-btn').hide();
                } else {
                    data.data.forEach(function(row, idx) {
                        tbody += '<tr>' +
                            '<td>' + (idx+1) + '</td>' +
                            '<td>' + row.case_id + '</td>' +
                            '<td>' + row.patient_name + '</td>' +
                            '<td>' + row.gender_age + '</td>' +
                            '<td>' + row.study_type + '</td>' +
                            '<td>' + row.date + '</td>' +
                            '<td>' + (parseFloat(row.amount).toFixed(2)) + '</td>' +
                            '</tr>';
                    });
                    tbody += '<tr id="total_summary_row">' +
                        '<td colspan="3" style="background:#e6f2ff;font-size:14px;font-weight:bold;color:#1a237e;">Total Number of Cases</td>' +
                        '<td style="background:#e6f2ff;font-size:14px;font-weight:bold;color:#1a237e;">' + data.data.length + '</td>' +
                        '<td colspan="2" style="background:#e6f2ff;font-size:14px;font-weight:bold;color:#1a237e;">Total Amount</td>' +
                        '<td style="background:#e6f2ff;font-size:14px;font-weight:bold;color:#1a237e;"><span class="d-block mt-1" style="font-weight:bold;">' + (data.total_amount ? parseFloat(data.total_amount).toFixed(2) : '0.00') + '</span></td>' +
                        '</tr>';
                    $('#save-qc-bill-btn').show();
                }
                $('#qc_bill_datatable tbody').html(tbody);
            },
            error: function() {
                $('#qc-bill-loading').hide();
                $('#qc_bill_datatable').show();
                $('#filter-qc-bill-btn').prop('disabled', false).html($('#filter-qc-bill-btn').data('original-text'));
                $('#qc-pdf-btn-container').hide();
            }
        });
    }
    // Save QC Bill button click
    $('#save-qc-bill-btn').off('click').on('click', function() {
        var $btn = $(this);
        $btn.prop('disabled', true).html('Saving...');
        var qcId = $('#qc_select').val();
        var startDate = $('#start_date').val();
        var endDate = $('#end_date').val();
        var totalAmount = 0;
        var totalCases = 0;
        var billData = [];
        $('#qc_bill_datatable tbody tr').each(function() {
            var $cells = $(this).find('td');
            if ($cells.length === 7 && !$(this).attr('id')) {
                billData.push({
                    case_id: $cells.eq(1).text(),
                    patient_name: $cells.eq(2).text(),
                    gender_age: $cells.eq(3).text(),
                    study_type: $cells.eq(4).text(),
                    date: $cells.eq(5).text(),
                    amount: parseFloat($cells.eq(6).text())
                });
                totalAmount += parseFloat($cells.eq(6).text());
                totalCases++;
            }
        });
        if (billData.length === 0) {
            Swal.fire({ icon: 'warning', title: 'No Data', text: 'No bill data to save.' });
            $btn.prop('disabled', false).html('Save Bill');
            return;
        }
        $.ajax({
            url: window.saveQcBillUrl,
            type: 'POST',
            contentType: 'application/json',
            data: JSON.stringify({
                qc_id: qcId,
                start_date: startDate,
                end_date: endDate,
                total_amount: totalAmount,
                total_cases: totalCases,
                bill_data: billData,
                _token: "{{ csrf_token() }}"
            }),
            success: function(resp) {
                if (resp.success) {
                    Swal.fire({ icon: 'success', title: 'Saved', text: 'QC bill saved successfully!' });
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
                    Swal.fire({ icon: 'error', title: 'Error', text: 'Failed to save QC bill.' });
                }
                $btn.prop('disabled', false).html('Save Bill');
            }
        });
    });
});
</script>
@endsection
