@extends('layouts.admin_layout')
@section('title', "View Doctors Data")
@section('extra_css')
<!-- CSS Switch -->
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
<link rel="stylesheet" href="{{asset('plugins/select2/css/select2.min.css')}}">
<link rel="stylesheet" href="{{asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">
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
                    <div class="card card-purple">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-md-10">
                                    <h3 class="card-title">View {{$pageName}} Data</h3>
                                </div>
                                <div class="col-md-2">
                                    <a href="{{ Route('admin.addDoctor') }}" style="margin-left:10px;" class="btn bg-gradient-success float-right" id="add_btn" name="add_btn">Add {{$pageName}}</a>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="doc_table" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Doctor Name</th>
                                        <th>Doctor Email</th>
                                        <th>Doctor Phone Number</th>
                                        <th>Modality</th>
                                        <th>Status</th>
                                        <th>Controls</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($doctors as $doctor)
                                    <tr>
                                        <td>{{$doctor->name}}</td>
                                        <td><a href="mailto:{{$doctor->email}}">{{$doctor->email}}</a></td>
                                        <td><a href="tel:+91{{$doctor->phone_number}}">{{$doctor->phone_number}}</a></td>
                                        <td>
                                            @foreach($doctor->DoctorModality as $DModality)
                                            <span class="badge bg-danger">{{$DModality->Modality->name}}</span>
                                            @endforeach
                                        </td>
                                        <td>
                                            <input type="checkbox" id="doc_status_{{$doctor->id}}" data-id="{{$doctor->id}}" @if($doctor->status==1) checked="checked" @endif class="doc_status" switch="bool" class="doc_status" /> 
                                            <label for="doc_status_{{$doctor->id}}" data-on-label="Active" data-off-label="Inactive"></label>
                                        </td>
                                        <td>
                                            <button type="button" data-id="{{$doctor->id}}" class="btn edit_btn btn-block bg-gradient-warning btn-xs"><i class="fas fa-edit"></i> Edit</button>
                                            <button type="button" data-id="{{$doctor->id}}" class="btn timeline_btn btn-block bg-gradient-blue btn-xs"><i class="fas fa-history"></i> View Timeline</button>
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
            <div class="row" id="edit_doc_div">
                
            </div>
            <!-- /.row -->
            <div class="row" id="doc_timeline">

            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
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
<script>
$(function () {
    $('#doc_table').DataTable({
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "responsive": true,
        "lengthMenu": [ [10, 25, 50, 100, 500, -1], [10, 25, 50, 100, 500, "All"] ],
    });

    $("#doc_table tbody").on("change", '.doc_status',function(){
        var isChecked = $(this).is(':checked');
        var doc_id = $(this).data("id");

        if (isChecked) {
            Swal.fire({
                title: "Are you sure?",
                text: "You want to enable this Doctor's Login?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, Enable It!"
            }).then((result) => {
                if (!result.isConfirmed) {
                    $(this).prop('checked', false);
                } else {
                    changeDocStatus(doc_id, isChecked);
                }
            });
        } else {
            Swal.fire({
                title: "Are you sure?",
                text: "You want to disabled this Doctor's Login?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, Disabled It!"
            }).then((result) => {
                if (!result.isConfirmed) {
                    $(this).prop('checked', true);
                } else {
                    changeDocStatus(doc_id, isChecked);
                }
            });
        }
    });
    
    $("#doc_table tbody").on("click", '.edit_btn',function(){
        removePreviousDivElements();
        $(this).html('Opening <i class="fas fa-spinner fa-spin"></i>');
        var doc_id = $(this).data("id");
        var form_data = new FormData();
        form_data.append('doc_id', doc_id);

        $.ajax({
            url: '{{url("admin/get-edit-doctor-data")}}',
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            type: 'post',
            success: function (data) {
                $(".edit_btn").html('<i class="fas fa-edit"></i> Edit');
                $("#edit_doc_div").html(data);
                scrollToAnchor("edit_form");
            },
            error: function (data){
                $(".edit_btn").html('<i class="fas fa-edit"></i> Edit');
            }
        });
    });

    $("#doc_table tbody").on("click", '.timeline_btn',function () {
        removePreviousDivElements();
        $(this).html('Opening <i class="fas fa-spinner fa-spin"></i>');
        var doc_id = $(this).data("id");
        var form_data = new FormData();
        form_data.append('doctor_id', doc_id);

        $.ajax({
            url: '{{url("admin/get-doc-timeline")}}',
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            type: 'post',
            success: function (data) {
                $(".timeline_btn").html('<i class="fas fa-history"></i> View Timeline');
                $("#doc_timeline").html(data);
                scrollToAnchor("view_timeline");
            },
            error: function (data) {
                $(".timeline_btn").html('<i class="fas fa-history"></i> View Timeline');
                printErrorMsg("Somthing went wrong! Reload the page.");
            }
        });
    });

    function removePreviousDivElements(){
        $("#edit_doc_div").html('');
        $("#doc_timeline").html('');
    }

    function changeDocStatus(doc_id, isChecked) {
        var form_data = new FormData();
        form_data.append('doc_id', doc_id);
        form_data.append('is_checked', isChecked);

        $.ajax({
            url: '{{url("admin/change-doctor-status")}}',
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