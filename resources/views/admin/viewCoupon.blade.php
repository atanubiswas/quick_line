@extends('layouts.admin_layout')
@section('title', "View Coupon Data")
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
                            <table id="coupon_table" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Coupon Code</th>
                                        <th>Percentage</th>
                                        <th>Min Amount</th>
                                        <th>Start Date</th>
                                        <th>End Date</th>
                                        <th>No of Coupon</th>
                                        <th>Total Use</th>
                                        <th>Status</th>
                                        <th>Controls</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($coupons as $coupon)
                                    <tr>
                                        <td>{{$coupon->code}}</td>
                                        <td>{{$coupon->amount}} %</td>
                                        <td>@if($coupon->minimum_spend==0) N/A @else <i class="fas fa-rupee-sign"></i>{{number_format($coupon->minimum_spend, 2)}} @endif</td>
                                        <td>{!!Carbon\Carbon::parse($coupon->start_date)->format("jS \of F Y")!!}</td>
                                        <td>{!!Carbon\Carbon::parse($coupon->end_date)->format("jS \of F Y")!!}</td>
                                        <td>@if($coupon->use_limit==0) Unlimited @else{{$coupon->use_limit}}@endif</td>
                                        <td>{{$coupon->total_use}}</td>
                                        <td>
                                            <input type="checkbox" id="coupon_status_{{$coupon->id}}" data-id="{{$coupon->id}}" @if($coupon->status==1) checked="checked" @endif class="coupon_status" switch="bool" class="lab_status" /> 
                                            <label for="coupon_status_{{$coupon->id}}" data-on-label="Active" data-off-label="Inactive"></label>
                                        </td>
                                        <td>
                                            <button type="button" data-id="{{$coupon->id}}" class="btn edit_btn btn-block bg-gradient-info btn-xs"><i class="fas fa-edit"></i> Edit</button>
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
            <div class="row" id="edit_coupon_div">
                
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
    $('#coupon_table').DataTable({
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "responsive": true,
        "lengthMenu": [ [10, 25, 50, 100, 500, -1], [10, 25, 50, 100, 500, "All"] ]
    });

    $('.coupon_status').on('change', function () {
        var isChecked = $(this).is(':checked');
        var coupon_id = $(this).data("id");

        if (isChecked) {
            Swal.fire({
                title: "Are you sure?",
                text: "You want to enable this Coupon?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, Enable It!"
            }).then((result) => {
                if (!result.isConfirmed) {
                    $(this).prop('checked', false);
                } else {
                    changeCouponStatus(coupon_id, isChecked);
                }
            });
        } else {
            Swal.fire({
                title: "Are you sure?",
                text: "You want to disabled this Coupon?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, Disabled It!"
            }).then((result) => {
                if (!result.isConfirmed) {
                    $(this).prop('checked', true);
                } else {
                    changeCouponStatus(coupon_id, isChecked);
                }
            });
        }
    });
    
    $(".edit_btn").on("click", function(){
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

    function changeCouponStatus(coupon_id, isChecked) {
        var form_data = new FormData();
        form_data.append('coupon_id', coupon_id);
        form_data.append('is_checked', isChecked);

        $.ajax({
            url: '{{url("admin/change-coupon-status")}}',
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