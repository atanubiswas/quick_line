@extends('layouts.admin_layout')
@section('title', "Add New User")
@section('extra_css')
<style type="text/css">
    label em{
        color: #FF0000;
    }
</style>
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
              <div class="card card-purple">
              <div class="card-header">
                <h3 class="card-title">Add {{$pageName}}</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form name="user_form" id="laboratory_form" method="post" action="">
                <div class="card-body">
                    <div class="form-group">
                      <label for="exampleInputEmail1">User Name <em>*</em></label>
                      <input type="text" class="form-control" required="required" name="user_name" id="user_name" placeholder="Enter User Name">
                    </div>
                    <div class="form-group">
                      <label for="exampleInputEmail1">User Email <em>*</em></label>
                      <input type="text" class="form-control" inputmode="email" required="required" name="user_login_email" id="user_login_email" placeholder="User Login Email">
                    </div>
                    <div class="form-group">
                      <label for="exampleInputEmail1">User Phone Number <em>*</em></label>
                      <input type="text" class="form-control" required="required" name="user_phone_number" id="user_phone_number" placeholder="User Phone Number">
                    </div>
                    <div class="form-group">
                      <label for="exampleInputEmail1">User Type <em>*</em></label>
                      <select id="user_type" name="user_type" class="form-control">
                            <option value="" selected disabled>Select User Role</option>
                            @foreach($roles as $role)
                            <option value="{{$role->id}}">{{ucFirst(str_replace('_', ' ', $role->name))}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                    <button type="button" id="save_btn" class="btn btn-success save_btn float-right">Save</button>
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
<script type="text/javascript">
$(function(){
  $('#user_phone_number').inputmask({
    mask: "9999-999-999",
    prefix: "+91 ",
    placeholder: "____-___-___",           // Optional: use space as placeholder
    showMaskOnHover: true,      // Don't show mask when not focused
    showMaskOnFocus: true,       // Show mask on focus
    onincomplete: function () {
        $(this).val('');         // Clear field if input is incomplete
    }
  });
$('#save_btn').on('click', function () {
    $(this).html('Saving <i class="fas fa-spinner fa-spin"></i>');
    $(".form-control").removeClass("is-invalid");
    $(".error").remove();
    var form_data = new FormData();
    var other_data = $('#laboratory_form').serializeArray();
    $.each(other_data, function (key, input) {
        form_data.append(input.name, input.value);
    });
    
    $.ajax({
        url: '{{url("admin/insert-user")}}',
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post',
        success: function (data) {
            $('#save_btn').html('Save');
            if ($.isEmptyObject(data.error)) {
                printSuccessMsg(data.success);
                $('#laboratory_form').trigger("reset");
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