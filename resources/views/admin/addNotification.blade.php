@extends('layouts.admin_layout')
@section('title', "Add New Notification Data")
@section('extra_css')
<style type="text/css">
    label em{
        color: #FF0000;
    }
</style>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/css/selectize.bootstrap3.min.css" integrity="sha256-ze/OEYGcFbPRmvCnrSeKbRTtjG4vGLHXgOqsyLFTRjg=" crossorigin="anonymous" />
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
              <form name="notification_form" id="notification_form" method="post" action="">
                <div class="card-body">
                    <div class="form-group">
                      <label for="exampleInputEmail1">Notification<em>*</em></label>
                      <textarea class="form-control" required="required" rows="3" name="notification" id="notification" placeholder="Enter Notification Text"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Notification For <em>*</em></label>
                        <select id="notification_for" name="notification_for" class="form-control">
                            <option value="all" selected="selected">All</option>
                            @foreach($roles as $role)
                            <option value="{{$role->id}}">{{ucFirst(str_replace('_', ' ', $role->name))}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group" id="select_user_div">
                        <label for="exampleInputEmail1">Select User <em>*</em></label>
                        <select id="select_user" name="select_user" class="form-control">
                            <option value="all" selected="selected">All</option>
                        </select>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/js/standalone/selectize.min.js" integrity="sha256-+C0A5Ilqmu4QcSPxrlGpaZxJ04VjsRjKu+G82kl5UJk=" crossorigin="anonymous"></script>
<script type="text/javascript">
$(function(){
    $('#select_user').selectize({
        sortField: 'text'
    });
    $("#notification_for").on("change", function(){
        var role_id = $(this).val();
        var form_data = new FormData();
        form_data.append("role_id", role_id);
        $.ajax({
            url: '{{url("admin/get-user-by-role")}}',
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            type: 'post',
            success: function (data) {
                if ($.isEmptyObject(data.error)) {
                    $('#select_user_div').html(data);
                    $('#select_user').selectize({
                        sortField: 'text'
                    });
                } else {
                    printErrorMsg(data.error);
                }
            },
            error: function (data) {
                printErrorMsg(data.error);
            }
        });
    });
    $('#save_btn').on('click', function () {
        $(this).html('Saving <i class="fas fa-spinner fa-spin"></i>');
        $(".form-control").removeClass("is-invalid");
        $(".error").remove();
        var form_data = new FormData();
        var other_data = $('#notification_form').serializeArray();
        $.each(other_data, function (key, input) {
            form_data.append(input.name, input.value);
        });
        
        $.ajax({
            url: '{{url("admin/insert-notification")}}',
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            type: 'post',
            success: function (data) {
                $('#save_btn').html('Save');
                if ($.isEmptyObject(data.error)) {
                    printSuccessMsg(data.success);
                    $('#notification_form').trigger("reset");
                } else {
                    printErrorMsg(data.error);
                }
            },
            error: function (data) {
                $('#save_btn').html('Save');
                printErrorMsg(data.error);
            }
        });
    });
});
</script>
@endsection