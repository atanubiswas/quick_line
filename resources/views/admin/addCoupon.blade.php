@extends('layouts.admin_layout')
@section('title', "Add New Coupon's Data")
@section('extra_css')
<style type="text/css">
    label em{
        color: #FF0000;
    }
</style>
<!-- daterange picker -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.39.0/css/tempusdominus-bootstrap-4.min.css" integrity="sha512-3JRrEUwaCkFUBLK1N8HehwQgu8e23jTH4np5NHOmQOobuC4ROQxFwFgBLTnhcnQRMs84muMh0PnnwXlPq5MGjg==" crossorigin="anonymous" />
@endsection
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">{{$pageName}}</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">{{$pageName}}</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Info boxes -->
        <div class="row">
          <div class="col-12 col-sm-6 col-md-12">
              <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Add {{$pageName}} Data</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form name="coupon_form" id="coupon_form" method="post" action="">
                <div class="card-body">
                    <div class="form-group">
                      <label for="exampleInputEmail1">Coupon Code <em>*</em></label>
                      <div class="input-group input-group-sm">
                        <input type="text" class="form-control" required="required" name="coupon_code" id="coupon_code" placeholder="Enter Coupon Code">
                        <span class="input-group-append">
                          <button type="button" id="generate_coupon_code" class="btn btn-info btn-flat">Generate Coupon Code!</button>
                        </span>
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="exampleInputEmail1">Coupon Percentage (%) <em>*</em></label>
                      <input type="text" class="form-control" required="required" name="coupon_percentage" id="coupon_percentage" placeholder="Coupon Percentage">
                    </div>
                    <div class="form-group">
                      <label for="exampleInputEmail1">Coupon Start Date <em>*</em></label>
                      <div class="input-group date" id="coupon_st_dt_div" data-target-input="nearest">
                          <input type="text" required="required" id="coupon_start_date" name="coupon_start_date" class="form-control datetimepicker-input" data-target="#coupon_st_dt_div" placeholder="Enter Coupon's Start Date">
                        <div class="input-group-append" data-target="#coupon_st_dt_div" data-toggle="datetimepicker">
                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                        </div>
                    </div>
                    </div>
                    <div class="form-group">
                      <label for="exampleInputEmail1">Coupon End Date <em>*</em></label>
                      <div class="input-group date" id="coupon_en_dt_div" data-target-input="nearest">
                          <input type="text" required="required" id="coupon_end_date" name="coupon_end_date" class="form-control datetimepicker-input" data-target="#coupon_en_dt_div" placeholder="Enter Coupon's End Date">
                        <div class="input-group-append" data-target="#coupon_en_dt_div" data-toggle="datetimepicker">
                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                        </div>
                    </div>
                    </div>
                    <div class="form-group">
                      <label for="exampleInputEmail1">Number of Coupons (Zero Means Unlimited)</label>
                      <input type="text" class="form-control" value='0' required="required" name="no_of_coupon" id="no_of_coupon" placeholder="No of Coupons">
                    </div>
                    <div class="form-group">
                      <label for="exampleInputEmail1">Minimum Spend Amount</label>
                      <input type="text" class="form-control" value='0' required="required" name="minimum_spend_amount" id="minimum_spend_amount" placeholder="No of Coupons">
                    </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                    <button type="button" id="save_btn" class="btn btn-primary save_btn">Save</button>
                </div>
              </form>
            </div>
            <!-- /.info-box -->
          </div>
        </div>
        <!-- /.row -->
      </div><!--/. container-fluid -->
    </section>
    <!-- /.content -->
  </div>
@endsection

@section("extra_js")
<!-- date-range-picker -->
<script src="{{asset('plugins/moment/moment.min.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.39.0/js/tempusdominus-bootstrap-4.min.js" integrity="sha512-k6/Bkb8Fxf/c1Tkyl39yJwcOZ1P4cRrJu77p83zJjN2Z55prbFHxPs9vN7q3l3+tSMGPDdoH51AEU8Vgo1cgAA==" crossorigin="anonymous"></script>
<script type="text/javascript">
$(function(){
    $('#coupon_st_dt_div').datetimepicker({
        format: 'DD/MM/YYYY'
    });
    
    $('#coupon_en_dt_div').datetimepicker({
        format: 'DD/MM/YYYY'
    });
    
    $('#generate_coupon_code').on('click', function(){
        $.ajax({
            url: '{{url("admin/generate-coupon-code")}}',
            cache: false,
            contentType: false,
            processData: false,
            type: 'post',
            success: function (data) {
                console.log(data.code);
                if ($.isEmptyObject(data.error)) {
                    $('#coupon_code').val(data.code);
                } else {
                    printErrorMsg(data.error);
                }
            }
        });
    });
    
    $('#save_btn').on('click', function () {
        $(this).html('Saving <i class="fas fa-spinner fa-spin"></i>');
        $(".form-control").removeClass("is-invalid");
        $(".error").remove();
        var form_data = new FormData();
        var other_data = $('#coupon_form').serializeArray();
        $.each(other_data, function (key, input) {
            form_data.append(input.name, input.value);
        });
        
        $.ajax({
            url: '{{url("admin/insert-coupon")}}',
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            type: 'post',
            success: function (data) {
                $('#save_btn').html('Save');
                if ($.isEmptyObject(data.error)) {
                    printSuccessMsg(data.success);
                    $('#collector_form').trigger("reset");
                } else {
                    printErrorMsg(data.error);
                }
            },
            error: function (data) {
                $('#save_btn').html('Save');
            }
        });
    });
});
</script>
@endsection