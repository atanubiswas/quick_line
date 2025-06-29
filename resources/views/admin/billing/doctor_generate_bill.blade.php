@extends('layouts.admin_layout')
@section('title', 'Generate Doctor Bill')
@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Generate Doctor Bill</h1>
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
                    <form id="doctor-bill-filter-form" class="form-row align-items-end">
                        <div class="form-group col-md-3">
                            <label for="doctor_select">Doctor</label>
                            <select id="doctor_select" name="doctor_id" class="form-control">
                                <option value="">-- Select Doctor --</option>
                                @foreach($doctors as $doctor)
                                    <option value="{{ $doctor->id }}">{{ $doctor->name }}</option>
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
                            <input type="checkbox" id="doctor-previous-month-checkbox" style="margin-right:5px;">
                            <label for="doctor-previous-month-checkbox" style="margin-bottom:0;margin-right:10px;">Previous Month</label>
                            <button type="button" id="filter-doctor-bill-btn" class="btn btn-primary">Generate Bill</button>
                            <a href="{{ route('admin.billing.saved_doctor_bills') }}" class="btn btn-info ml-2" id="view-saved-doctor-bills-btn">View Saved Bills</a>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card mt-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title mb-0">Doctor Bill Data</h3>
                    <div class="flex-grow-1"></div>
                    <button id="save-doctor-bill-btn" class="btn btn-warning ml-auto" style="display:none;">Save Bill</button>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <div id="doctor-bill-loading" style="display:none;text-align:center;padding:30px;">
                            <span class="spinner-border spinner-border-sm text-primary" role="status" aria-hidden="true"></span>
                            <span>Generating...</span>
                        </div>
                        <table class="table table-bordered table-hover" id="doctor_bill_datatable">
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
                    <div id="doctor-pdf-btn-container" style="margin-top: 20px; display: none;">
                        <form id="doctor-pdf-export-form" method="GET" action="{{ route('admin.billing.doctor_generate_bill_pdf') }}" style="display:inline;">
                            <input type="hidden" name="doctor_id" id="pdf_doctor_id">
                            <input type="hidden" name="start_date" id="pdf_start_date">
                            <input type="hidden" name="end_date" id="pdf_end_date">
                            <button type="submit" id="download-doctor-pdf-btn" class="btn btn-success ml-2" style="background-color: #28a745; border-color: #28a745;">
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
    var doctorBillDataUrl = "{{ route('admin.billing.doctor_generate_bill_data') }}";
    window.saveDoctorBillUrl = "{{ route('admin.billing.save_doctor_bill') }}";
</script>
<script src="{{asset('/js/doctor-export-excel.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="{{ asset('/js/doctor-bill-pdf.js') }}"></script>
<script>
$(document).ready(function() {
    $('#doctor_select').select2({ width: '100%', placeholder: '-- Select Doctor --', allowClear: true });
    // Save Doctor Bill button click (moved from JS file)
    $('#save-doctor-bill-btn').off('click').on('click', function() {
        var $btn = $(this);
        $btn.prop('disabled', true).html('Saving...');
        var doctorId = $('#doctor_select').val();
        var startDate = $('#start_date').val();
        var endDate = $('#end_date').val();
        var totalAmount = 0;
        var totalCases = 0;
        var billData = [];
        $('#doctor_bill_datatable tbody tr').each(function() {
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
            url: window.saveDoctorBillUrl,
            type: 'POST',
            contentType: 'application/json',
            data: JSON.stringify({
                doctor_id: doctorId,
                start_date: startDate,
                end_date: endDate,
                total_amount: totalAmount,
                total_cases: totalCases,
                bill_data: billData,
                _token: "{{ csrf_token() }}"
            }),
            success: function(resp) {
                if (resp.success) {
                    Swal.fire({ icon: 'success', title: 'Saved', text: 'Doctor bill saved successfully!' });
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
                    Swal.fire({ icon: 'error', title: 'Error', text: 'Failed to save doctor bill.' });
                }
                $btn.prop('disabled', false).html('Save Bill');
            }
        });
    });
});
</script>
<script src="{{ asset('/js/doctor-bill-generate.js') }}"></script>
@endsection
