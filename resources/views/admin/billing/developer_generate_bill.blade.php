@extends('layouts.admin_layout')
@section('title', 'Generate Developer Bill')

@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Generate Developer Bill</h1>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <form id="generateBillForm">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Start Date</label>
                                            <input type="date" value="{{ $startDate }}" class="form-control" id="start_date" name="start_date" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>End Date</label>
                                            <input type="date" value="{{ $endDate }}" class="form-control" id="end_date" name="end_date" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-12">
                                        <button type="button" class="btn btn-primary" id="generateBillBtn">Generate Bill</button>
                                    </div>
                                </div>
                            </form>

                            <div id="billPreview" class="mt-4" style="display: none;">
                                <h4>Bill Preview</h4>
                                <div class="table-responsive" id="bill_table_container">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Case ID</th>
                                                <th>Patient Name</th>
                                                <th>Gender/Age</th>
                                                <th>Date</th>
                                                <th>Amount (₹)</th>
                                            </tr>
                                        </thead>
                                        <tbody id="billTable">
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th colspan="4" class="text-right">Total Amount:</th>
                                                <th id="totalAmount">₹0</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                                <div class="mt-3">
                                    <form id="developer-pdf-export-form" method="GET" action="{{ route('admin.billing.developer_generate_pdf') }}" style="display:inline;">
                                        <input type="hidden" name="start_date" id="pdf_start_date">
                                        <input type="hidden" name="end_date" id="pdf_end_date">
                                        <button type="button" id="download-developer-pdf-btn" class="btn btn-success ml-2" style="background-color: #28a745; border-color: #28a745;">
                                            Download PDF
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('extra_js')
@parent
<script>
$(document).ready(function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
    });

    $('#generateBillBtn').on('click', function() {
        let startDate = $('#start_date').val();
        let endDate = $('#end_date').val();
        
        // Show loading state
        let submitBtn = $(this).find('button[type="submit"]');
        submitBtn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Generating...');

        $.ajax({
            url: '{{ route("admin.billing.developer_generate_data") }}',
            method: 'POST',
            data: {
                start_date: startDate,
                end_date: endDate
            },
            success: function(response) {
                submitBtn.prop('disabled', false).text('Generate Bill');
                $('#billTable').empty();
                if(response.error) {
                    alert(response.error);
                    return;
                }

                $("#bill_table_container").html(response);
                $('#billPreview').show();
            },
            error: function(xhr, status, error) {
                submitBtn.prop('disabled', false).text('Generate Bill');
                alert('Error generating bill: ' + (xhr.responseJSON?.error || error));
            }
        });
    });

    $('#download-developer-pdf-btn').on('click', function() {
        let startDate = $('#start_date').val();
        let endDate = $('#end_date').val();
        console.log('PDF Start Date:', startDate, 'PDF End Date:', endDate);
        $('#pdf_start_date').val(startDate);
        $('#pdf_end_date').val(endDate);
        $('#developer-pdf-export-form').submit();
    });
});
</script>
@endsection
