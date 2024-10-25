@extends('layouts.admin_layout')
@section('title', "Add New Pathology Test Package")
@section('extra_css')
<style type="text/css">
    label em{
        color: #FF0000;
    }
    .select2-selection { background-color: #343a40 !important; }
    .select2-selection__choice { background-color: #6f42c1 !important; border-color: #643ab0 !important; }
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
              <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Add {{$pageName}} Package</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form name="pathology_test_form" id="pathology_test_form" method="post" action="">
                <div class="card-body">
                    <div class="form-group">
                      <label for="exampleInputEmail1">Package Name <em>*</em></label>
                      <input type="text" class="form-control" required="required" name="test_name" id="test_name" placeholder="Enter Test Name">
                    </div>
                    <div class="form-group">
                      <label for="exampleInputEmail1">Select Tests <em>*</em></label>
                      <select class="form-control select2" required="required" multiple="multiple" name="pathology_test_categorie_id" id="pathology_test_categorie_id">
                          @foreach($pathologyTests as $pathologyTest)
                          <option value="{{$pathologyTest->id}}">{{$pathologyTest->test_name}}</option>
                          @endforeach
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
<script src="{{asset('plugins/select2/js/select2.full.min.js')}}"></script>
<script type="text/javascript">
$(function(){
    $('.select2').select2({
      theme: 'bootstrap4'
    })
    $('#save_btn').on('click', function () {
        $(this).html('Saving <i class="fas fa-spinner fa-spin"></i>');
        $(".form-control").removeClass("is-invalid");
        $(".error").remove();
        var form_data = new FormData();
        var other_data = $('#pathology_test_form').serializeArray();
        $.each(other_data, function (key, input) {
            form_data.append(input.name, input.value);
        });
        
        $.ajax({
            url: '{{url("admin/insert-pathology-test")}}',
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