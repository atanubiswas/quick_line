@extends('layouts.admin_layout')
@section('title', "Add New Doctor's Data")
@section('extra_css')
<style type="text/css">
    label em{
        color: #FF0000;
    }
</style>
<link rel="stylesheet" href="{{asset('plugins/select2/css/select2.min.css')}}">
<link rel="stylesheet" href="{{asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">
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
              <form name="doctor_form" id="doctor_form" method="post" action="" accept="multipart/form-data">
                <div class="card-body">
                    <div class="form-group">
                      <label for="exampleInputEmail1">Name <em>*</em></label>
                      <input type="text" class="form-control" required="required" name="doctor_name" id="doctor_name" placeholder="Enter Doctor's Name">
                    </div>
                    <div class="form-group">
                      <label for="exampleInputEmail1">Login Email <em>*</em></label>
                      <input type="text" class="form-control" required="required" name="doctor_login_email" id="doctor_login_email" placeholder="Doctor's Login Email">
                    </div>
                    <div class="form-group">
                      <label for="exampleInputEmail1">Phone Number<em>*</em></label>
                      <input type="text" class="form-control" required="required" name="doctor_phone_number" id="doctor_phone_number" placeholder="Doctor's Phone Number">
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
                      <label for="exampleInputEmail1">Signature <em>*</em></label>
                      <input type="file" class="form-control"  accept="image/*" required="required" name="doctor_signature" id="doctor_signature" accept=".png, .jpg, .jpeg">
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
<script src="{{asset('plugins/select2/js/select2.full.min.js')}}"></script>
<script type="text/javascript">
$(function(){
    $('.select2').select2({
      theme: 'bootstrap4',
      placeholder: '-- Select Modality --',
      selectionCssClass: 'bg-purple'
    });
    $('#doctor_phone_number').inputmask({
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
        var other_data = $('#doctor_form').serializeArray();
        $.each(other_data, function (key, input) {
            form_data.append(input.name, input.value);
        });
        
        var fileInput = $('#doctor_signature')[0];
        if (fileInput.files.length > 0) {
            form_data.append('doctor_signature', fileInput.files[0]);
        }

        $.ajax({
            url: '{{url("admin/insert-doctor")}}',
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            type: 'post',
            success: function (data) {
                $('#save_btn').html('Save');
                if ($.isEmptyObject(data.error)) {
                    printSuccessMsg(data.success);
                    $('#doctor_form').trigger("reset");
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