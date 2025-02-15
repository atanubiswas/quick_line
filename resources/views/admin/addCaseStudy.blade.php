@extends('layouts.admin_layout')
@section('title', "Add Case Study")
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
                <h3 class="card-title">Add {{$pageName}} Data</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form name="laboratory_form" id="laboratory_form" method="post" action="">
                <div class="card-body">
                    <div class="form-group">
                      <label for="exampleInputEmail1">Centre Name <em>*</em></label>
                      <input type="text" class="form-control" required="required" name="lab_name" id="lab_name" placeholder="Enter Centre Name">
                    </div>
                    <div class="form-group">
                      <label for="exampleInputEmail1">Centre Email <em>*</em></label>
                      <input type="text" class="form-control" inputmode="email" required="required" name="lab_login_email" id="lab_login_email" placeholder="Centre Login Email">
                    </div>
                    <div class="form-group">
                      <label for="exampleInputEmail1">Centre Phone Number <em>*</em></label>
                      <input type="text" class="form-control" required="required" name="lab_phone_number" id="lab_phone_number" placeholder="Centre Phone Number">
                    </div>
                    <div class="form-group">
                      <label for="exampleInputEmail1">Modality <em>*</em></label>
                      <select class="form-control select2" required="required" multiple="multiple" name="modality[]" id="modality">
                        @foreach($modalityes as $modality)
                        <option value="{{$modality->id}}">{{$modality->name}}</option>
                        @endforeach
                      </select>
                    </div>
                    <div class="form-group">
                      <label for="exampleInputEmail1">Centre Location <em>*</em></label>
                      <input type="text" class="form-control" required="required" name="lab_primary_location" id="lab_primary_location" placeholder="Centre Primary Location">
                    </div>
                    @include('admin.includes.extra_fields')
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
    $('#lab_phone_number').inputmask({
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
            url: '{{url("admin/insert-laboratory")}}',
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