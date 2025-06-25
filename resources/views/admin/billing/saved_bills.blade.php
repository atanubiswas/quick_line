@extends('layouts.admin_layout')
@section('title', 'Saved Bills')
@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Saved Bills</h1>
                </div>
            </div>
        </div>
    </div>
    <section class="content">
        <div class="container-fluid">
            <div class="card card-success">
                <div class="card-header">
                    <h3 class="card-title">Search Bills</h3>
                </div>
                <div class="card-body">
                    <form id="search-bills-form" class="form-row align-items-end">
                        <div class="form-group col-md-4">
                            <label for="search_centre_id">Centre</label>
                            <select id="search_centre_id" name="centre_id" class="form-control">
                                <option value="">-- All Centres --</option>
                                @foreach($centres as $centre)
                                    <option value="{{ $centre->id }}">{{ $centre->lab_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="search_start_date">Start Date</label>
                            <input type="date" id="search_start_date" name="start_date" class="form-control">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="search_end_date">End Date</label>
                            <input type="date" id="search_end_date" name="end_date" class="form-control">
                        </div>
                        <div class="form-group col-md-2">
                            <button type="button" id="search-bills-btn" class="btn btn-primary w-100">Search</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card mt-4">
                <div class="card-header bg-purple text-white">
                    <h3 class="card-title">Bills List</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover" id="bills_table">
                            <thead>
                                <tr>
                                    <th>Invoice</th>
                                    <th>Centre</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Total Amount</th>
                                    <th>Total Study</th>
                                    <th>Paid</th>
                                    <th>Invoice Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(request()->has('centre_id') || request()->has('start_date') || request()->has('end_date'))
                                    @foreach($bills as $bill)
                                    <tr>
                                        <td>{{ $bill->invoice_number }}</td>
                                        <td>{{ $bill->centre->lab_name ?? '' }}</td>
                                        <td>{{ \Carbon\Carbon::parse($bill->start_date)->format('d/m/Y') }}</td>
                                        <td>{{ \Carbon\Carbon::parse($bill->end_date)->format('d/m/Y') }}</td>
                                        <td>{{ $bill->total_amount }}</td>
                                        <td>{{ $bill->total_study }}</td>
                                        <td>
                                            <input type="checkbox" class="toggle-paid" data-bill-id="{{ $bill->id }}" data-current="{{ $bill->is_paid }}" {{ $bill->is_paid ? 'checked' : '' }} data-toggle="toggle" data-on="Yes" data-off="No" data-onstyle="success" data-offstyle="danger">
                                        </td>
                                        <td>{{ \Carbon\Carbon::parse($bill->created_at)->format('d/m/Y') }}</td>
                                        <td>
                                            <button type="button" class="btn btn-info btn-sm view-bill-btn" data-bill-id="{{ $bill->id }}">View Bill</button>
                                            <button type="button" class="btn bg-gradient-indigo btn-sm download-excel-btn" data-bill-id="{{ $bill->id }}">Download Excel</button>
                                            <form method="GET" action="{{ route('admin.billing.export_pdf') }}" style="display:inline;">
                                                <input type="hidden" name="centre_id" value="{{ $bill->centre_id }}">
                                                <input type="hidden" name="start_date" value="{{ $bill->start_date }}">
                                                <input type="hidden" name="end_date" value="{{ $bill->end_date }}">
                                                <button type="submit" class="btn btn-warning btn-sm ml-1">Download PDF</button>
                                            </form>
                                            <button type="button" class="btn btn-danger btn-sm delete-bill-btn" data-bill-id="{{ $bill->id }}">Delete</button>
                                            <input type="hidden" id="excel_centre_name_{{ $bill->id }}" value="{{ $bill->centre->lab_name ?? '' }}">
                                            <input type="hidden" id="excel_start_date_{{ $bill->id }}" value="{{ $bill->start_date }}">
                                            <input type="hidden" id="excel_end_date_{{ $bill->id }}" value="{{ $bill->end_date }}">
                                            <div style="display:none;">
                                                <table id="bill_excel_table_{{ $bill->id }}">
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
                                                        @php $billData = json_decode($bill->bill_data, true); @endphp
                                                        @foreach($billData as $idx => $row)
                                                        <tr>
                                                            <td>{{ $idx+1 }}</td>
                                                            <td>{{ $row['patient_id'] }}</td>
                                                            <td>{{ $row['patient_name'] }}</td>
                                                            <td>{{ $row['gender_age'] }}</td>
                                                            <td>{{ $row['modality'] }}</td>
                                                            <td>{{ isset($row['study_type'])?$row['study_type']:"-" }}</td>
                                                            <td>{{ isset($row['date'])?$row['date']:"-" }}</td>
                                                            <td>{{ isset($row['reported_on'])?$row['reported_on']:"-" }}</td>
                                                            <td>@if(isset($row['amount'])){{ is_numeric($row['amount']) ? number_format($row['amount'], 2) : $row['amount'] }}@else - @endif</td>
                                                        </tr>
                                                        @endforeach
                                                        <tr>
                                                            <td colspan="3" style="background:#e6f2ff;font-size:14px;font-weight:bold;color:#1a237e;">Total Number of Study</td>
                                                            <td class="text-right font-weight-bold" style="background:#e6f2ff;font-size:14px;font-weight:bold;color:#1a237e;">{{ count($billData) }}</td>
                                                            <td colspan="2" style="background:#e6f2ff;"></td>
                                                            <td colspan="2" style="background:#e6f2ff;font-size:14px;font-weight:bold;color:#1a237e;">Total Amount</td>
                                                            <td style="background:#e6f2ff;font-size:14px;font-weight:bold;color:#1a237e;"><span class="d-block mt-1" style="font-weight:bold;">{{ $bill->total_amount ? number_format($bill->total_amount, 2) : '0.00' }}</span></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
@section('extra_js')
@parent
<!-- Bootstrap Toggle CSS/JS (CDN) -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script>
<!-- SweetAlert2 CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{asset('/js/export-excel.js')}}"></script>
<script>
function exportSavedBillToExcel(tableId, centreName, startDate, endDate) {
    // Temporarily set global hidden fields for export-excel.js to pick up
    var oldCentre = document.getElementById('centre_select');
    var oldStart = document.getElementById('start_date');
    var oldEnd = document.getElementById('end_date');
    // Create temp fields if not present
    var tempCentre = document.createElement('input');
    tempCentre.type = 'hidden'; tempCentre.id = 'centre_select'; tempCentre.value = centreName;
    var tempStart = document.createElement('input');
    tempStart.type = 'hidden'; tempStart.id = 'start_date'; tempStart.value = startDate;
    var tempEnd = document.createElement('input');
    tempEnd.type = 'hidden'; tempEnd.id = 'end_date'; tempEnd.value = endDate;
    document.body.appendChild(tempCentre);
    document.body.appendChild(tempStart);
    document.body.appendChild(tempEnd);
    exportTableToExcel(tableId, '');
    // Remove temp fields
    document.body.removeChild(tempCentre);
    document.body.removeChild(tempStart);
    document.body.removeChild(tempEnd);
}
$(document).ready(function() {
    // Auto-select centre if centre_id is in URL
    var urlParams = new URLSearchParams(window.location.search);
    var centreId = urlParams.get('centre_id');
    if (centreId) {
        $('#search_centre_id').val(centreId);
    }

    $('#search-bills-btn').on('click', function() {
        var centreId = $('#search_centre_id').val();
        var startDate = $('#search_start_date').val();
        var endDate = $('#search_end_date').val();
        var url = new URL(window.location.href);
        if (centreId) url.searchParams.set('centre_id', centreId); else url.searchParams.delete('centre_id');
        if (startDate) url.searchParams.set('start_date', startDate); else url.searchParams.delete('start_date');
        if (endDate) url.searchParams.set('end_date', endDate); else url.searchParams.delete('end_date');
        window.location.href = url.toString();
    });

    // Handle paid toggle with SweetAlert2 confirm
    $('.toggle-paid').change(function(e) {
        var checkbox = $(this);
        var billId = checkbox.data('bill-id');
        var isPaid = checkbox.prop('checked') ? 1 : 0;
        var confirmText = isPaid ? 'mark this bill as PAID' : 'mark this bill as UNPAID';
        Swal.fire({
            title: 'Are you sure?',
            text: 'You are about to ' + confirmText + '.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, confirm',
            cancelButtonText: 'Cancel',
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '{{ route("admin.billing.mark_paid") }}',
                    method: 'POST',
                    data: {
                        bill_id: billId,
                        is_paid: isPaid,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(res) {
                        if(res.success) {
                            Swal.fire('Success', 'Payment status updated.', 'success');
                        } else {
                            Swal.fire('Error', 'Failed to update payment status.', 'error');
                            checkbox.prop('checked', !isPaid).bootstrapToggle('destroy').bootstrapToggle(isPaid ? 'off' : 'on');
                        }
                    },
                    error: function() {
                        Swal.fire('Error', 'Error updating payment status.', 'error');
                        checkbox.prop('checked', !isPaid).bootstrapToggle('destroy').bootstrapToggle(isPaid ? 'off' : 'on');
                    }
                });
            } else {
                checkbox.prop('checked', !isPaid).bootstrapToggle('destroy').bootstrapToggle(isPaid ? 'off' : 'on');
            }
        });
    });

    // View Bill button click handler
    $(document).on('click', '.view-bill-btn', function() {
        var billId = $(this).data('bill-id');
        $('#billDataModalBody').html('<div class="text-center"><span class="spinner-border"></span> Loading...</div>');
        $('#billDataModal').modal('show');
        $.ajax({
            url: '{{ route("admin.billing.get_bill_data") }}',
            method: 'GET',
            data: { bill_id: billId },
            success: function(res) {
                if(res.success) {
                    $('#billDataModalBody').html(res.html);
                } else {
                    $('#billDataModalBody').html('<div class="alert alert-danger">Failed to load bill data.</div>');
                }
            },
            error: function() {
                $('#billDataModalBody').html('<div class="alert alert-danger">Error loading bill data.</div>');
            }
        });
    });

    // Delete Bill button click handler
    $(document).on('click', '.delete-bill-btn', function() {
        var billId = $(this).data('bill-id');
        Swal.fire({
            title: 'Are you sure?',
            text: 'This will delete the bill. You can regenerate it if needed.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel',
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '{{ route("admin.billing.delete_bill") }}',
                    method: 'POST',
                    data: {
                        bill_id: billId,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(res) {
                        if(res.success) {
                            Swal.fire('Deleted!', 'Bill has been deleted.', 'success').then(() => {
                                location.reload();
                            });
                        } else {
                            Swal.fire('Error', 'Failed to delete bill.', 'error');
                        }
                    },
                    error: function() {
                        Swal.fire('Error', 'Error deleting bill.', 'error');
                    }
                });
            }
        });
    });

    // Download Excel for saved bills
    $('.download-excel-btn').on('click', function() {
        var btn = $(this);
        var originalText = btn.text();
        btn.text('Downloading...').prop('disabled', true);
        var billId = btn.data('bill-id');
        var centreName = $('#excel_centre_name_' + billId).val();
        var startDate = $('#excel_start_date_' + billId).val();
        var endDate = $('#excel_end_date_' + billId).val();
        exportSavedBillToExcel('bill_excel_table_' + billId, centreName, startDate, endDate);
        setTimeout(function() {
            btn.text(originalText).prop('disabled', false);
        }, 2000); // fallback in case export is fast
    });

    // Download PDF for saved bills
    $(document).on('submit', 'form[action$="export_pdf"]', function(e) {
        var btn = $(this).find('button[type="submit"]');
        var originalText = btn.text();
        btn.text('Downloading...').prop('disabled', true);
        setTimeout(function() {
            btn.text(originalText).prop('disabled', false);
        }, 4000); // fallback, as form submit will reload or download
    });
});
</script>
@endsection

<!-- View Bill Modal -->
<div class="modal fade" id="viewBillModal" tabindex="-1" role="dialog" aria-labelledby="viewBillModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewBillModalLabel">Bill Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Bill details will be loaded here via AJAX -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Bill Data Modal -->
<div class="modal fade" id="billDataModal" tabindex="-1" role="dialog" aria-labelledby="billDataModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="billDataModalLabel">Bill Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="billDataModalBody">
        <!-- Bill data will be loaded here -->
        <div class="text-center"><span class="spinner-border"></span> Loading...</div>
      </div>
    </div>
  </div>
</div>
