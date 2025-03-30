@extends('layouts.admin_layout')
@section('title', "Add New Study Layout")
@section('extra_css')
<style type="text/css">
    label em{
        color: #FF0000;
    }
</style>
<link rel="stylesheet" href="{{asset('plugins/select2/css/select2.min.css')}}">
<link rel="stylesheet" href="{{asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">
<!-- summernote -->
<link rel="stylesheet" href="{{asset('plugins/summernote/summernote-bs4.min.css')}}">
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
              <form name="study_layout_form" id="study_layout_form" method="post" action="">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Modality <em>*</em></label>
                                <select class="form-control select2" required="required" name="modality" id="modality">
                                    <option value="">Select Modality</option>
                                    @foreach($modalityes as $modality)
                                    <option value="{{$modality->id}}">{{$modality->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Study <em>*</em></label>
                                <select class="form-control select2 study_id" required="required" name="study_id" id="study_id">
                                    <option value="">Select Study</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Layout For <em>*</em></label>
                                <select class="form-control select2 doctor_id" required="required" name="doctor_id" id="doctor_id">
                                    <option value="0" selected="selected">All Doctors</option>
                                    @foreach($doctors as $doctor)
                                    <option value="{{$doctor->user_id}}">{{$doctor->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                            <label for="exampleInputEmail1">Layout <em>*</em></label>
                                <textarea id="layout" name="layout"></textarea>
                            </div>
                        </div>
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
<script src="{{asset('plugins/select2/js/select2.full.min.js')}}"></script>
<!-- Summernote -->
<script src="{{asset('plugins/summernote/summernote-bs4.min.js')}}"></script>
<script type="text/javascript">
$(function(){
    $('#modality').select2({
      theme: 'bootstrap4',
      placeholder: '-- Select Modality --',
      selectionCssClass: 'bg-purple'
    });
    $('#study_id').select2({
      theme: 'bootstrap4',
      placeholder: '-- Select Study --',
      selectionCssClass: 'bg-purple'
    });
    $('#doctor_id').select2({
      theme: 'bootstrap4',
      placeholder: '-- All Doctors --',
      selectionCssClass: 'bg-purple'
    });

    $('#layout').summernote();

    $("#modality").on("change", function (e) {
        var modality =  $(this).val();
        if (modality != '') {
            $.ajax({
                url: "{{ route('get-study-type') }}",
                type: "POST",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "modality_id": modality
                },
                success: function (response) {
                    $('.study_id').html(response);
                }
            });
        }
    });

    $('#save_btn').on('click', function () {
        $(this).html('Saving <i class="fas fa-spinner fa-spin"></i>');
        $(".form-control").removeClass("is-invalid");
        $(".error").remove();
        var form_data = new FormData();
        var other_data = $('#study_layout_form').serializeArray();
        $.each(other_data, function (key, input) {
            form_data.append(input.name, input.value);
        });
        
        $.ajax({
            url: '{{url("admin/insert-study-layout")}}',
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            type: 'post',
            success: function (data) {
                $('#save_btn').html('Save');
                if ($.isEmptyObject(data.error)) {
                    printSuccessMsg(data.success);
                    $('#study_layout_form').trigger("reset");
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