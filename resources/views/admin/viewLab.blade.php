@extends('layouts.admin_layout')
@section('title', "View Laboratory Data")
@section('extra_css')
<!-- CSS Switch -->
<link rel="stylesheet" href="{{asset('css/css_switch.css')}}">
<style type="text/css">
    label em{
        color: #FF0000;
    }
</style>
<!--Plugin CSS file with desired skin-->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ion-rangeslider/2.3.1/css/ion.rangeSlider.min.css"/>
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
                                    <a href="{{ Route('admin.addLab') }}" style="margin-left:10px;" class="btn bg-gradient-success float-right" id="add_btn" name="add_btn">Add {{$pageName}}</a>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="lab_table" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Centre Name</th>
                                        <th>Centre Location</th>
                                        <th>Centre Email</th>
                                        <th>Centre Phone Number</th>
                                        <th>Modality</th>
                                        <th>Status</th>
                                        <th>Controls</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($labratoryes as $labratorye)
                                    <tr>
                                        <td>{{$labratorye->lab_name}}</td>
                                        <td>{{$labratorye->lab_primary_location}}</td>
                                        <td><a href="mailto:{{$labratorye->user->email}}">{{$labratorye->user->email}}</a></td>
                                        <td><a href="tel:+91{{$labratorye->lab_phone_number}}">{{$labratorye->lab_phone_number}}</a></td>
                                        <td>
                                            @foreach($labratorye->labModality as $labModality)
                                            <span class="badge bg-purple">{{$labModality->modality->name}}</span>
                                            @endforeach
                                        </td>
                                        <td>
                                            <input type="checkbox" id="lab_status_{{$labratorye->id}}" data-id="{{$labratorye->id}}" @if($labratorye->status==1) checked="checked" @endif class="lab_status" switch="bool" /> 
                                            <label for="lab_status_{{$labratorye->id}}" data-on-label="Active" data-off-label="Inactive"></label>
                                        </td>
                                        <td>
                                            <button type="button" data-id="{{$labratorye->id}}" class="btn edit_btn btn-block bg-gradient-warning btn-xs"><i class="fas fa-edit"></i> Edit</button>
                                            <button type="button" data-id="{{$labratorye->id}}" class="btn add_documents_btn btn-block bg-gradient-success btn-xs"><i class="fas fa-file-import"></i> Add Document</button>
                                            <button type="button" data-id="{{$labratorye->id}}" class="btn view_documents_btn btn-block bg-gradient-indigo btn-xs"><i class="fas fa-id-card"></i> View Documents</button>
                                            <button type="button" data-id="{{$labratorye->id}}" class="btn timeline_btn btn-block bg-gradient-blue btn-xs"><i class="fas fa-history"></i> View Timeline</button>
                                            <button type="button" data-id="{{$labratorye->id}}" class="btn preferred_doc_btn btn-block bg-gradient-cyan btn-xs"><i class="fas fa-user-md"></i> Preferred Doctors</button>
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
            <div class="row" id="edit_lab_div">
                
            </div>
            <!-- /.row -->
            <div class="row" id="add_documents">

            </div>
            <!-- /.row -->
            <div class="row" id="view_documents">

            </div>
            <!-- /.row -->
            <div class="row" id="lab_timeline">

            </div>
            <!-- /.row -->
            <div class="row" id="preferred_doc_div">

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
<!--Plugin JavaScript file-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/ion-rangeslider/2.3.1/js/ion.rangeSlider.min.js"></script>
<script>
$(function () {
    $('#lab_table').DataTable({
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "responsive": true,
        "lengthMenu": [ [10, 25, 50, 100, 500, -1], [10, 25, 50, 100, 500, "All"] ]
    });

    $('#lab_table tbody').on('change', '.lab_status',function () {
        var isChecked = $(this).is(':checked');
        var lab_id = $(this).data("id");

        if (isChecked) {
            Swal.fire({
                title: "Are you sure?",
                text: "You want to enable this Laboratory?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, Enable It!"
            }).then((result) => {
                if (!result.isConfirmed) {
                    $(this).prop('checked', false);
                } else {
                    changeLabStatus(lab_id, isChecked);
                }
            });
        } else {
            Swal.fire({
                title: "Are you sure?",
                text: "You want to disabled this Laboratory?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, Disabled It!"
            }).then((result) => {
                if (!result.isConfirmed) {
                    $(this).prop('checked', true);
                } else {
                    changeLabStatus(lab_id, isChecked);
                }
            });
        }
    });

    $("#lab_table tbody").on("click", '.edit_btn',function(){
        removePreviousDivElements();
        $(this).html('Opening <i class="fas fa-spinner fa-spin"></i>');
        var lab_id = $(this).data("id");
        var form_data = new FormData();
        form_data.append('lab_id', lab_id);

        $.ajax({
            url: '{{url("admin/get-edit-laboratory-data")}}',
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            type: 'post',
            success: function (data) {
                $(".edit_btn").html('<i class="fas fa-edit"></i> Edit');
                $("#edit_lab_div").html(data);
                scrollToAnchor("edit_form");
            },
            error: function (data){
                $(".edit_btn").html('<i class="fas fa-edit"></i> Edit');
            }
        });
    });
    
    $("#lab_table tbody").on("click", '.timeline_btn',function () {
        removePreviousDivElements();
        $(this).html('Opening <i class="fas fa-spinner fa-spin"></i>');
        var lab_id = $(this).data("id");
        var form_data = new FormData();
        form_data.append('lab_id', lab_id);

        $.ajax({
            url: '{{url("admin/get-lab-timeline")}}',
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            type: 'post',
            success: function (data) {
                $(".timeline_btn").html('<i class="fas fa-history"></i> View Timeline');
                $("#lab_timeline").html(data);
                scrollToAnchor("view_timeline");
            },
            error: function (data) {
                $(".timeline_btn").html('<i class="fas fa-history"></i> View Timeline');
                printErrorMsg("Somthing went wrong! Reload the page.");
            }
        });
    });
    
    $("#lab_table tbody").on("click", '.add_documents_btn',function () {
        removePreviousDivElements();
        $(this).html('Opening <i class="fas fa-spinner fa-spin"></i>');
        var lab_id = $(this).data("id");
        var form_data = new FormData();
        form_data.append('lab_id', lab_id);

        $.ajax({
            url: '{{url("admin/add-document-ajax")}}',
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            type: 'post',
            success: function (data) {
                $(".add_documents_btn").html('<i class="fas fa-file-import"></i> Add Document');
                $("#add_documents").html(data);
                scrollToAnchor("add_document");
            },
            error: function (data) {
                $(".add_documents_btn").html('<i class="fas fa-file-import"></i> Add Document');
                printErrorMsg("Somthing went wrong! Reload the page.");
            }
        });
    });

    $("#lab_table tbody").on("click", '.preferred_doc_btn',function () {
        removePreviousDivElements();
        $(this).html('Opening <i class="fas fa-spinner fa-spin"></i>');
        var lab_id = $(this).data("id");
        var form_data = new FormData();
        form_data.append('lab_id', lab_id);

        $.ajax({
            url: '{{url("admin/get-preferred-doc")}}',
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            type: 'post',
            success: function (data) {
                $(".preferred_doc_btn").html('<i class="fas fa-user-md"></i> Preferred Doctors');
                $("#preferred_doc_div").html(data);
                scrollToAnchor("preferred-doc");
            },
            error: function (data) {
                $(".preferred_doc_btn").html('<i class="fas fa-user-md"></i> Preferred Doctors');
                printErrorMsg("Somthing went wrong! Reload the page.");
            }
        });
    });

    $("#lab_table tbody").on("click", '.view_documents_btn',function () {
        removePreviousDivElements();
        $(this).html('Opening <i class="fas fa-spinner fa-spin"></i>');
        var lab_id = $(this).data("id");
        var form_data = new FormData();
        form_data.append('id', lab_id);
        form_data.append('type', 'centre');

        $.ajax({
            url: '{{url("admin/get-documents")}}',
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            type: 'post',
            success: function (data) {
                $(".view_documents_btn").html('<i class="fas fa-id-card"></i> View Documents');
                $("#view_documents").html(data);
                scrollToAnchor("document_table");
            },
            error: function (data) {
                $(".view_documents_btn").html('<i class="fas fa-id-card"></i> View Documents');
                printErrorMsg("Somthing went wrong! Reload the page.");
            }
        });
    });

    function removePreviousDivElements(){
        $("#edit_lab_div").html('');
        $("#add_documents").html('');
        $("#view_documents").html('');
        $("#lab_timeline").html('');
        $("#preferred_doc_div").html('');
    }
    
    function changeLabStatus(lab_id, isChecked) {
        var form_data = new FormData();
        form_data.append('lab_id', lab_id);
        form_data.append('is_checked', isChecked);

        $.ajax({
            url: '{{url("admin/change-laboratory-status")}}',
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