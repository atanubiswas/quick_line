@extends('layouts.admin_layout')
@section('title', 'Saved Doctor Bills')
@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Saved Doctor Bills</h1>
                </div>
            </div>
        </div>
    </div>
    <section class="content">
        <div class="container-fluid">
            <div class="card card-secondary">
                <div class="card-header">
                    <h3 class="card-title">Filter</h3>
                </div>
                <div class="card-body">
                    <form method="GET" class="form-row align-items-end mb-3">
                        <div class="form-group col-md-4">
                            <label for="doctor_id">Doctor</label>
                            <select name="doctor_id" id="doctor_id" class="form-control">
                                <option value="">-- All Doctors --</option>
                                @foreach($doctors as $doctor)
                                    <option value="{{ $doctor->id }}" {{ request('doctor_id') == $doctor->id ? 'selected' : '' }}>{{ $doctor->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="start_date">Start Date</label>
                            <input type="date" name="start_date" id="start_date" class="form-control" value="{{ request('start_date') }}">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="end_date">End Date</label>
                            <input type="date" name="end_date" id="end_date" class="form-control" value="{{ request('end_date') }}">
                        </div>
                        <div class="form-group col-md-2">
                            <button type="submit" class="btn btn-primary">Filter</button>
                        </div>
                    </form>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Bill Number</th>
                                    <th>Doctor</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Total Cases</th>
                                    <th>Total Amount</th>
                                    <th>Status</th>
                                    <th>Created At</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(request()->has('doctor_id') || request()->has('start_date') || request()->has('end_date'))
                                    @forelse($bills as $idx => $bill)
                                        <tr>
                                            <td>{{ $idx+1 }}</td>
                                            <td>{{ $bill->bill_number ?? '-' }}</td>
                                            <td>{{ $bill->doctor->name ?? '-' }}</td>
                                            <td>{{ $bill->start_date ? \Carbon\Carbon::parse($bill->start_date)->format('d/m/Y') : '' }}</td>
                                            <td>{{ $bill->end_date ? \Carbon\Carbon::parse($bill->end_date)->format('d/m/Y') : '' }}</td>
                                            <td>{{ $bill->total_cases }}</td>
                                            <td>{{ number_format($bill->total_amount, 2) }}</td>
                                            <td>
                                                <input type="checkbox" class="toggle-paid-status" data-bill-id="{{ $bill->id }}" {{ $bill->is_paid ? 'checked' : '' }} data-toggle="toggle" data-on="Paid" data-off="Unpaid" data-onstyle="success" data-offstyle="warning">
                                            </td>
                                            <td>{{ $bill->created_at ? \Carbon\Carbon::parse($bill->created_at)->format('d/m/Y') : '' }}</td>
                                            <td>
                                                <form method="GET" action="{{ route('admin.billing.doctor_generate_bill_pdf') }}" style="display:inline;">
                                                    <input type="hidden" name="doctor_id" value="{{ $bill->doctor_id }}">
                                                    <input type="hidden" name="start_date" value="{{ $bill->start_date }}">
                                                    <input type="hidden" name="end_date" value="{{ $bill->end_date }}">
                                                    <button type="submit" class="btn btn-sm btn-success ml-2" title="Download PDF"><i class="fa fa-file-pdf-o"></i> PDF</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="10" class="text-center">No bills found.</td></tr>
                                    @endforelse
                                @else
                                    <tr><td colspan="10" class="text-center">Please use the filter to view saved bills.</td></tr>
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
<link href="https://cdn.jsdelivr.net/npm/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script>
<script>
$(document).ready(function() {
    $('#doctor_id').select2({ width: '100%', placeholder: '-- All Doctors --', allowClear: true });
    $('.toggle-paid-status').bootstrapToggle();
    $(document).on('change', '.toggle-paid-status', function(e) {
        var checkbox = $(this);
        var billId = checkbox.data('bill-id');
        var isPaid = checkbox.prop('checked') ? 1 : 0;
        var statusText = isPaid ? 'mark this bill as PAID' : 'mark this bill as UNPAID';
        // Revert toggle until confirmed
        checkbox.bootstrapToggle('disable');
        Swal.fire({
            title: 'Are you sure?',
            text: 'You are about to ' + statusText + '.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, update',
            cancelButtonText: 'Cancel',
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ route('admin.billing.mark_doctor_bill_paid') }}",
                    type: 'POST',
                    data: {
                        bill_id: billId,
                        is_paid: isPaid,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(resp) {
                        if (resp.success) {
                            Swal.fire({ icon: 'success', title: 'Updated', text: 'Bill status updated.' });
                        } else {
                            Swal.fire({ icon: 'error', title: 'Error', text: 'Failed to update status.' });
                            checkbox.bootstrapToggle('toggle');
                        }
                        checkbox.bootstrapToggle('enable');
                    },
                    error: function() {
                        Swal.fire({ icon: 'error', title: 'Error', text: 'Failed to update status.' });
                        checkbox.bootstrapToggle('toggle');
                        checkbox.bootstrapToggle('enable');
                    }
                });
            } else {
                checkbox.bootstrapToggle('toggle');
                checkbox.bootstrapToggle('enable');
            }
        });
    });
});
</script>
@endsection
