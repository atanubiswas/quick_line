@extends('layouts.admin_layout')
@section('title', "View Wallet Data")
@section('extra_css')
<!-- CSS Switch -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<link rel="stylesheet" href="{{asset('css/css_switch.css')}}">
<style type="text/css">
    label em{
        color: #FF0000;
    }
</style>
<!-- DataTables -->
<link rel="stylesheet" href="{{asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css')}}">
@endsection
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{$pageName}} Data</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">{{$pageName}} Data</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-3 col-6">

                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{number_format($totalBalance->balance)}} <sup style="font-size: 20px"><i class="fas fa-rupee-sign"></i></sup></h3>
                            <p>Total Wallet Balance</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-wallet"></i>
                        </div>
                        <div class="small-box-footer">&nbsp;</div>
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>{{number_format($thisMonthBalanceAdd->total_amount)}} <sup style="font-size: 20px"><i class="fas fa-rupee-sign"></i></sup></h3>
                            <p>Total <i class="fas fa-rupee-sign"></i> Added This Month</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-coins"></i>
                        </div>
                        <div class="small-box-footer">&nbsp;</div>
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3>{{number_format($thisMonthBalanceSub->total_amount)}} <sup style="font-size: 20px"><i class="fas fa-rupee-sign"></i></sup></h3>
                            <p>Total <i class="fas fa-rupee-sign"></i> Deduct This Month</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-hand-holding-usd"></i>
                        </div>
                        <div class="small-box-footer">&nbsp;</div>
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>@if($lastTransaction->direction=='Debit')-@endif {{number_format($lastTransaction->amount)}} <sup style="font-size: 20px"><i class="fas fa-rupee-sign"></i></sup></h3>
                            <p>Last Entry on {{ \Carbon\Carbon::parse($lastTransaction->transaction_date)->isoFormat('Do MMM, YY') }}</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-receipt"></i>
                        </div>
                        <div class="small-box-footer">&nbsp;</div>
                    </div>
                </div>

            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">View {{$pageName}} Data</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>View Transactions</label>
                                        <select class="form-control" name="view_transactions" id="view_transactions">
                                            <option value="last_10" selected="selected">Last 10 Transactions</option>
                                            <option value="current_week">Current Week</option>
                                            <option value="last_week">Last Week</option>
                                            <option value="current_month">Current Month</option>
                                            <option value="last_month">Last Month</option>
                                            <option value="custom">Custom Date</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="row" id="date_block" style="display: none">
                                        <div class="col-sm-6">
                                            <label>Start Date</label>
                                            <input type="text" id="start_date" name="start_date" placeholder="Start Date" class="form-control" placeholder=".col-3">
                                        </div>
                                        <div class="col-sm-6">
                                            <label>End Date</label>
                                            <input type="text" id="end_date" name="end_date" placeholder="End Date" class="form-control" placeholder=".col-3">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <label>&nbsp;</label>
                                    <button type="button" data-id="{{$collector->id}}" id="transaction_search_btn" class="btn btn-block bg-gradient-warning"><i class="fas fa-search"></i> Search</button>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                    <div class="card">
                        <div class="card-header">

                        </div>
                        <div class="card-body">
                            <div class="row" id="transaction_table_div">
                                <div class="col-sm-12">
                                    <table id="transaction_table" class="table table-sm">
                                        <thead>
                                            <tr>
                                                <th style="width: 30%">Details</th>
                                                <th style="width: 30%">Time</th>
                                                <th style="width: 20%">Done By</th>
                                                <th style="width: 10%">Amount</th>
                                                <th style="width: 10%">Balance</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(count($transactions)>0)
                                            @foreach($transactions as $transaction)
                                            <tr>
                                                <td>
                                                    @if($transaction->direction == 'Credit')
                                                    <p class="text-success">{{$transaction->transaction_type}}</p>
                                                    @else
                                                    <p class="text-danger">{{$transaction->transaction_type}}</p>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($transaction->direction == 'Credit')
                                                    <p class="text-success"> {{ \Carbon\Carbon::parse($transaction->transaction_date)->isoFormat('Do MMMM, YYYY, hh:mm:ss A') }} </p>
                                                    @else
                                                    <p class="text-danger"> {{ \Carbon\Carbon::parse($transaction->transaction_date)->isoFormat('Do MMMM, YYYY, hh:mm:ss A') }} </p>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($transaction->direction == 'Credit')
                                                    <p class="text-success">{{$transaction->transaction_by_data->name}} ({{$transaction->transaction_by_type}})</p>
                                                    @else
                                                    <p class="text-danger">{{$transaction->transaction_by_data->name}} ({{$transaction->transaction_by_type}})</p>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($transaction->direction == 'Credit')
                                                    <p class="text-success"><i class="fas fa-rupee-sign"></i> {{number_format($transaction->amount,2)}}</p>
                                                    @else
                                                    <p class="text-danger"><i class="fas fa-rupee-sign"></i> -{{number_format($transaction->amount, 2)}}</p>
                                                    @endif
                                                </td>

                                                <td><p class="text-info"><i class="fas fa-rupee-sign"></i> {{number_format($transaction->after_amount,2)}}</p></td>
                                            </tr>
                                            @endforeach
                                            @else
                                            <tr>
                                                <td colspan="5"> No Data Found.</td>
                                            </tr>
                                            @endif
                                            <tr>

                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
            <div class="row" id="edit_collector_div">

            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>

<div class="modal fade" id="addWalletBalanceModal" tabindex="-1" role="dialog" aria-labelledby="addWalletBalanceModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content" id="modal-content-wallet_balance">

        </div>
    </div>
</div>

<div class="modal fade " id="viewTransactionsModal" tabindex="-1" role="dialog" aria-labelledby="viewTransactionsModal" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content" id="modal-content-view-transactions">

        </div>
    </div>
</div>
@endsection

@section("extra_js")
<!-- DataTables  & Plugins -->
<script src="{{asset('plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>
<script src="{{asset('plugins/datatables-buttons/js/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('plugins/datatables-buttons/js/buttons.bootstrap4.min.js')}}"></script>
<script src="{{asset('plugins/jszip/jszip.min.js')}}"></script>
<script src="{{asset('plugins/pdfmake/pdfmake.min.js')}}"></script>
<script src="{{asset('plugins/pdfmake/vfs_fonts.js')}}"></script>
<script src="{{asset('plugins/datatables-buttons/js/buttons.html5.min.js')}}"></script>
<script src="{{asset('plugins/datatables-buttons/js/buttons.print.min.js')}}"></script>
<script src="{{asset('plugins/datatables-buttons/js/buttons.colVis.min.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
$(function () {
    flatpickr("#start_date", {
        enableTime: false,
        dateFormat: "Y-m-d",
        altInput: true,
        altFormat: "F j, Y",
        maxDate: "today"
    });
    flatpickr("#end_date", {
        enableTime: false,
        dateFormat: "Y-m-d",
        altInput: true,
        altFormat: "F j, Y",
        maxDate: "today"
    });
    $("#view_transactions").on('change', function () {
        var val = $(this).val();
        if (val === 'custom') {
            $("#date_block").show('slow');
        } else {
            $("#date_block").hide('slow');
        }
    });

    $("#transaction_search_btn").on("click", function () {
        var collector_id = $(this).data('id');
        var transaction_type = $("#view_transactions").val();
        var start_date = $("#start_date").val();
        var end_date = $("#end_date").val();
        if (transaction_type === 'custom') {
            if (start_date === '' || end_date === '') {
                Swal.fire({
                    title: 'Error!',
                    html: 'Please select Start Date & End Date.',
                    icon: 'error',
                    confirmButtonText: 'Close',
                    timer: 10000,
                    timerProgressBar: true
                });
                return false;
            }

            if (new Date(start_date) > new Date(end_date)) {
                Swal.fire({
                    title: 'Error!',
                    html: 'End date cannot be earlier than start date.',
                    icon: 'error',
                    confirmButtonText: 'Close',
                    timer: 10000,
                    timerProgressBar: true
                });
                return false;
            }
        }
        var form_data = new FormData();
        form_data.append('collector_id', collector_id);
        form_data.append('transaction_type', transaction_type);
        form_data.append('start_date', start_date);
        form_data.append('end_date', end_date);
        $.ajax({
            url: '{{url("admin/get-transaction-data")}}',
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            type: 'post',
            success: function (data) {
                $('#transaction_table_div').html(data);
            },
            error: function (data) {
            }
        });
    });
});
</script>
@endsection