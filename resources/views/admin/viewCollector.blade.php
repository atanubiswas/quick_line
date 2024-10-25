@extends('layouts.admin_layout')
@section('title', "View Collector Data")
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
                    <h1>{{$pageName}}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">{{$pageName}}</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">View {{$pageName}} Data</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="collector_table" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Collector Name</th>
                                        <th>Collector Location</th>
                                        <th>Collector Email</th>
                                        <th>Wallet Balance</th>
                                        <th>Status</th>
                                        <th>Controls</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($collectors as $collector)
                                    <tr>
                                        <td>{{$collector->collector_name}}</td>
                                        <td>{{$collector->collector_primary_location}}</td>
                                        <td><a href="mailto:{{$collector->collector_login_email}}">{{$collector->collector_login_email}}</a></td>
                                        <td><i class="fas fa-rupee-sign"></i> {{$collector->user->wallet->balance}}</td>
                                        <td>
                                            <input type="checkbox" id="collector_status_{{$collector->id}}" data-id="{{$collector->id}}" @if($collector->status==1) checked="checked" @endif class="collector_status" switch="bool" class="collector_status" /> 
                                            <label for="collector_status_{{$collector->id}}" data-on-label="Active" data-off-label="Inactive"></label>
                                        </td>
                                        <td>
                                            <button type="button" data-id="{{$collector->id}}" class="btn btn-block bg-gradient-info btn-xs edit_btn"><i class="fas fa-edit"></i> Edit</button>
                                            <button type="button" data-id="{{$collector->id}}" class="btn btn-block bg-gradient-purple btn-xs approve_documents"><i class="fas fa-id-card"></i> Approve Documents</button>
                                            <button type="button" data-id="{{$collector->id}}" class="btn btn-block bg-gradient-warning btn-xs add_wallet_balance"><i class="fas fa-rupee-sign"></i> Add Wallet Balance</button>
                                            <button type="button" data-id="{{$collector->id}}" class="btn btn-block bg-gradient-danger btn-xs view_transactions"><i class="fas fa-rupee-sign"></i> View Transactions</button>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->

                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
            <div class="row" id="edit_collector_div">

            </div>
            <div class="row" id="collector_document_div">

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
</div>+
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
    $('#collector_table').DataTable({
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "responsive": true,
        "lengthMenu": [[10, 25, 50, 100, 500, -1], [10, 25, 50, 100, 500, "All"]]
    });

    $('.collector_status').on('change', function () {
        var isChecked = $(this).is(':checked');
        var collector_id = $(this).data("id");

        if (isChecked) {
            Swal.fire({
                title: "Are you sure?",
                text: "You want to enable this Collector's Login?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, Enable It!"
            }).then((result) => {
                if (!result.isConfirmed) {
                    $(this).prop('checked', false);
                } else {
                    changeCollectorStatus(collector_id, isChecked);
                }
            });
        } else {
            Swal.fire({
                title: "Are you sure?",
                text: "You want to disabled this Collector's Login?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, Disabled It!"
            }).then((result) => {
                if (!result.isConfirmed) {
                    $(this).prop('checked', true);
                } else {
                    changeCollectorStatus(collector_id, isChecked);
                }
            });
        }
    });
    
    $(".add_wallet_balance").on("click", function(){
        var collector_id = $(this).data("id");
        var form_data = new FormData();
        form_data.append('collector_id', collector_id);
        $.ajax({
            url: '{{url("admin/get-wallet-balance-modal-data")}}',
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            type: 'post',
            success: function (data) {
                $('#modal-content-wallet_balance').html(data);
                $('#addWalletBalanceModal').modal('show');
            },
            error: function (data) {
                printErrorMsg("Somthing went wrong! Reload the page.");
            }
        });
    });
    
    $(".approve_documents").on("click", function () {
        $(this).html('Opening <i class="fas fa-spinner fa-spin"></i>');
        var collector_id = $(this).data("id");
        var form_data = new FormData();
        form_data.append('id', collector_id);
        form_data.append('type', 'collector');

        $.ajax({
            url: '{{url("admin/get-documents")}}',
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            type: 'post',
            success: function (data) {
                $(".approve_documents").html('<i class="fas fa-id-card"></i> Approve Documents');
                $("#collector_document_div").html(data);
                scrollToAnchor("document_table");
            },
            error: function (data) {
                printErrorMsg("Somthing went wrong! Reload the page.");
            }
        });
    });
    
    $(".view_transactions").on("click", function(){
        var collector_id = $(this).data("id");
        var form_data = new FormData();
        form_data.append('collector_id', collector_id);
        $.ajax({
            url: '{{url("admin/get-transactions-modal-data")}}',
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            type: 'post',
            success: function (data) {
                $('#modal-content-view-transactions').html(data);
                $('#viewTransactionsModal').modal('show');
                $(".view_transactions").html('<i class="fas fa-rupee-sign"></i> View Transactions');
            },
            error: function (data) {
                printErrorMsg("Somthing went wrong! Reload the page.");
                $(".view_transactions").html('<i class="fas fa-rupee-sign"></i> View Transactions');
            }
        });
    });

    $(".edit_btn").on("click", function () {
        $(this).html('Opening <i class="fas fa-spinner fa-spin"></i>');
        var collector_id = $(this).data("id");
        var form_data = new FormData();
        form_data.append('collector_id', collector_id);

        $.ajax({
            url: '{{url("admin/get-edit-collector-data")}}',
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            type: 'post',
            success: function (data) {
                $(".edit_btn").html('<i class="fas fa-edit"></i> Edit');
                $("#edit_collector_div").html(data);
                scrollToAnchor("edit_form");
            },
            error: function (data) {
                printErrorMsg("Somthing went wrong! Reload the page.");
            }
        });
    });

    function changeCollectorStatus(collector_id, isChecked) {
        var form_data = new FormData();
        form_data.append('collector_id', collector_id);
        form_data.append('is_checked', isChecked);

        $.ajax({
            url: '{{url("admin/change-collector-status")}}',
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            type: 'post',
            success: function (data) {
                printSuccessMsg(data.success);
            }
        });
    }
});
</script>
@endsection