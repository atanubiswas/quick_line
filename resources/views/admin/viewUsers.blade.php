@extends('layouts.admin_layout')
@section('title', "View Users")
@section('extra_css')
<!-- CSS Switch -->
<link rel="stylesheet" href="{{asset('css/css_switch.css')}}">
<style type="text/css">
    label em{
        color: #FF0000;
    }

    .user-image-table{
        width: 35px;
        margin: 0 10px;
    }
</style>
<!--Plugin CSS file with desired skin-->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ion-rangeslider/2.3.1/css/ion.rangeSlider.min.css"/>
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
                    <div class="card card-purple">
                        <div class="card-header">
                            <h3 class="card-title">View Managers</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="manager_table" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>User Name</th>
                                        <th>Email</th>
                                        <th>Mobile Number</th>
                                        <th>User Type</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($users as $user)
                                    @if($user->roles[0]->name == 'Manager')
                                    <tr>
                                        <td><img src="{{$user->user_image}}" class="img-circle elevation-2 user-image-table" alt="User Image">{{$user->name}}</td>
                                        <td><a href="mailto:{{$user->email}}">{{$user->email}}</a></td>
                                        <td><a href="tel:+91{{$user->mobile_number}}">{{$user->mobile_number}}</a></td>
                                        <td>{{$user->roles[0]->name}}</td>
                                        <td>
                                            <input type="checkbox" @if($authUser->roles[0]->name !== 'Admin' && $user->roles[0]->name == 'Manager') disabled @endif id="user_status_{{$user->id}}" data-id="{{$user->id}}" @if($user->status==1) checked="checked" @endif class="user_status" switch="bool" /> 
                                            <label for="user_status_{{$user->id}}"  @if($authUser->roles[0]->name !== 'Admin' && $user->roles[0]->name == 'Manager') style="background-color: #aaa" @endif data-on-label="Active" data-off-label="Inactive"></label>
                                        </td>
                                    </tr>
                                    @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                    <div class="card card-purple">
                        <div class="card-header">
                            <h3 class="card-title">View Assigners</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="assigner_table" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>User Name</th>
                                        <th>Email</th>
                                        <th>Mobile Number</th>
                                        <th>User Type</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($users as $user)
                                    @if($user->roles[0]->name == 'Assigner')
                                    <tr>
                                        <td><img src="{{$user->user_image}}" class="img-circle elevation-2 user-image-table" alt="User Image">{{$user->name}}</td>
                                        <td><a href="mailto:{{$user->email}}">{{$user->email}}</a></td>
                                        <td><a href="tel:+91{{$user->mobile_number}}">{{$user->mobile_number}}</a></td>
                                        <td>{{$user->roles[0]->name}}</td>
                                        <td>
                                            <input type="checkbox" @if($authUser->roles[0]->name !== 'Admin' && $user->roles[0]->name == 'Manager') disabled @endif id="user_status_{{$user->id}}" data-id="{{$user->id}}" @if($user->status==1) checked="checked" @endif class="user_status" switch="bool" /> 
                                            <label for="user_status_{{$user->id}}"  @if($authUser->roles[0]->name !== 'Admin' && $user->roles[0]->name == 'Manager') style="background-color: #aaa" @endif data-on-label="Active" data-off-label="Inactive"></label>
                                        </td>
                                    </tr>
                                    @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                    <div class="card card-purple">
                        <div class="card-header">
                            <h3 class="card-title">View Quality Controllers</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="quality_controller_table" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>User Name</th>
                                        <th>Email</th>
                                        <th>Mobile Number</th>
                                        <th>User Type</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($users as $user)
                                    @if($user->roles[0]->name == 'Quality Controller')
                                    <tr>
                                        <td><img src="{{$user->user_image}}" class="img-circle elevation-2 user-image-table" alt="User Image">{{$user->name}}</td>
                                        <td><a href="mailto:{{$user->email}}">{{$user->email}}</a></td>
                                        <td><a href="tel:+91{{$user->mobile_number}}">{{$user->mobile_number}}</a></td>
                                        <td>{{$user->roles[0]->name}}</td>
                                        <td>
                                            <input type="checkbox" @if($authUser->roles[0]->name !== 'Admin' && $user->roles[0]->name == 'Manager') disabled @endif id="user_status_{{$user->id}}" data-id="{{$user->id}}" @if($user->status==1) checked="checked" @endif class="user_status" switch="bool" />
                                            <label for="user_status_{{$user->id}}"  @if($authUser->roles[0]->name !== 'Admin' && $user->roles[0]->name == 'Manager') style="background-color: #aaa" @endif data-on-label="Active" data-off-label="Inactive"></label>
                                        </td>
                                    </tr>
                                    @endif
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
    $('#manager_table').DataTable({
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "responsive": true,
        "lengthMenu": [ [10, 25, 50, 100, 500, -1], [10, 25, 50, 100, 500, "All"] ]
    });

    $('#assigner_table').DataTable({
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "responsive": true,
        "lengthMenu": [ [10, 25, 50, 100, 500, -1], [10, 25, 50, 100, 500, "All"] ]
    });

    $('#quality_controller_table').DataTable({
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "responsive": true,
        "lengthMenu": [ [10, 25, 50, 100, 500, -1], [10, 25, 50, 100, 500, "All"] ]
    });

    $('#manager_table tbody').on('change', '.user_status',function () {
        var isChecked = $(this).is(':checked');
        var user_id = $(this).data("id");

        if (isChecked) {
            Swal.fire({
                title: "Are you sure?",
                text: "You want to Re-active this Person?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, Re-active It!"
            }).then((result) => {
                if (!result.isConfirmed) {
                    $(this).prop('checked', false);
                } else {
                    changeUserStatus(user_id, isChecked);
                }
            });
        } else {
            Swal.fire({
                title: "Are you sure?",
                text: "You want to Deactive this Person?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, Deactive It!"
            }).then((result) => {
                if (!result.isConfirmed) {
                    $(this).prop('checked', true);
                } else {
                    changeUserStatus(user_id, isChecked);
                }
            });
        }
    });

    $('#assigner_table tbody').on('change', '.user_status',function () {
        var isChecked = $(this).is(':checked');
        var user_id = $(this).data("id");

        if (isChecked) {
            Swal.fire({
                title: "Are you sure?",
                text: "You want to Re-active this Person?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, Re-active It!"
            }).then((result) => {
                if (!result.isConfirmed) {
                    $(this).prop('checked', false);
                } else {
                    changeUserStatus(user_id, isChecked);
                }
            });
        } else {
            Swal.fire({
                title: "Are you sure?",
                text: "You want to Deactive this Person?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, Deactive It!"
            }).then((result) => {
                if (!result.isConfirmed) {
                    $(this).prop('checked', true);
                } else {
                    changeUserStatus(user_id, isChecked);
                }
            });
        }
        });

    $('#quality_controller_table tbody').on('change', '.user_status',function () {
        var isChecked = $(this).is(':checked');
        var user_id = $(this).data("id");

        if (isChecked) {
            Swal.fire({
                title: "Are you sure?",
                text: "You want to Re-active this Person?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, Re-active It!"
            }).then((result) => {
                if (!result.isConfirmed) {
                    $(this).prop('checked', false);
                } else {
                    changeUserStatus(user_id, isChecked);
                }
            });
        } else {
            Swal.fire({
                title: "Are you sure?",
                text: "You want to Deactive this Person?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, Deactive It!"
            }).then((result) => {
                if (!result.isConfirmed) {
                    $(this).prop('checked', true);
                } else {
                    changeUserStatus(user_id, isChecked);
                }
            });
        }
    });
    
    function changeUserStatus(user_id, isChecked) {
        var form_data = new FormData();
        form_data.append('user_id', user_id);
        form_data.append('is_checked', isChecked);

        $.ajax({
            url: '{{url("admin/change-user-status")}}',
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