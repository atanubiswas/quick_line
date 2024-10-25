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
                                        <th>Status</th>
                                        <th>Controls</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($appliedCollectors as $appliedCollector)
                                    @php
                                        $collector = $appliedCollector->collector;
                                    @endphp
                                    <tr>
                                        <td>{{$collector->collector_name}}</td>
                                        <td>{{$collector->collector_primary_location}}</td>
                                        <td><a href="mailto:{{$collector->collector_login_email}}">{{$collector->collector_login_email}}</a></td>
                                        <td><span class="badge  {{$appliedCollector->button_type}} " id="status_div_{{$collector->id}}">{{ucwords($appliedCollector->status)}}</span></td>
                                        <td>
                                            <button type="button" data-id="{{$collector->id}}" class="btn btn-block bg-gradient-purple btn-sm approve_btn"><i class="far fa-thumbs-up"></i> Approve</button>
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
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<template id="approve_collector_alert_template">
<swal-title>
    Want to approve this Collector?
</swal-title>
<swal-icon type="warning" color="yellow"></swal-icon>

<swal-button type="confirm" color="#28a745">
    Approved
</swal-button>
<swal-button type="cancel">
    Cancel
</swal-button>
<swal-button type="deny">
    Reject
</swal-button>
</template>
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
    
    $(".approve_btn").on("click", function () {
        $(this).html('Updating <i class="fas fa-spinner fa-spin"></i>');
        var collector_id = $(this).data("id");
        var form_data = new FormData();
        form_data.append('collector_id', collector_id);
        Swal.fire({
            template: "#approve_collector_alert_template",
            backdrop: true,
            allowEnterKey: false,
            focusConfirm: true
        }).then((result) => {
            if (result.isConfirmed) {
                form_data.append('status', 'approved');
                $.ajax({
                    url: '{{url("admin/approve-collector")}}',
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: form_data,
                    type: 'post',
                    success: function (data) {
                        $(".approve_btn").html('<i class="fas fa-id-card"></i> Approve');
                        $("#status_div_"+collector_id).html('Approved');
                        $("#status_div_"+collector_id).removeClass('bg-info bg-warning bg-danger bg-success');
                        $("#status_div_"+collector_id).addClass('bg-success');
                        Swal.fire("Collector' Application Approved.", "", "success");
                    },
                    error: function (data) {
                        $(".approve_btn").html('<i class="fas fa-id-card"></i> Approve');
                        Swal.fire("Somthing Wrong Happend.", "Please Refresh the page.", "error");
                    }
                });
            } else if (result.isDenied) {
                form_data.append('status', 'rejected');
                $.ajax({
                    url: '{{url("admin/approve-collector")}}',
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: form_data,
                    type: 'post',
                    success: function (data) {
                        $(".approve_btn").html('<i class="fas fa-id-card"></i> Approve');
                        $("#status_div_"+collector_id).html('Rejected');
                        $("#status_div_"+collector_id).removeClass('bg-info bg-warning bg-danger bg-success');
                        $("#status_div_"+collector_id).addClass('bg-danger');
                        Swal.fire("Collector's Application Rejected.", "", "error");
                    },
                    error: function (data) {
                        $(".approve_btn").html('<i class="fas fa-id-card"></i> Approve');
                        Swal.fire("Somthing Wrong Happend.", "Please Refresh the page.", "error");
                    }
                });
            }
            else if (result.isDismissed){
                $(".approve_btn").html('<i class="fas fa-id-card"></i> Approve');
            }
        });
    });
});
</script>
@endsection