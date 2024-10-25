@extends('layouts.admin_layout')
@section('title', "Add New Pathology Test Data")
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
              <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Add {{$pageName}} Data</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form name="pathology_test_form" id="pathology_test_form" method="post" action="">
                <div class="card-body">
                    <div class="form-group">
                      <label for="exampleInputEmail1">Test Name <em>*</em></label>
                      <input type="text" class="form-control" required="required" name="test_name" id="test_name" placeholder="Enter Test Name">
                    </div>
                    <div class="form-group">
                      <label for="exampleInputEmail1">Test Code <em>*</em></label>
                      <input type="text" class="form-control" required="required" name="test_code" id="test_code" placeholder="Enter Test Code">
                    </div>
                    <div class="form-group">
                      <label for="exampleInputEmail1">Select Category <em>*</em></label>
                      <select class="form-control" required="required" name="pathology_test_categorie_id" id="pathology_test_categorie_id">
                          <option value="" selected="selected">Select Category</option>
                          @foreach($pathologyCategory as $category)
                          <option value="{{$category->id}}">{{$category->category_name}}</option>
                          @endforeach
                      </select>
                    </div>
                    <div class="form-group">
                      <label for="exampleInputEmail1">Description</label>
                      <textarea class="form-control" name="description" id="description" placeholder="Enter Test Description"></textarea>
                    </div>
                    <div class="form-group">
                      <label for="exampleInputEmail1">Test Price <em>*</em></label>
                      <input type="text" class="form-control" required="required" name="price" id="price" placeholder="Enter Test Price">
                    </div>
                    <div class="form-group">
                      <label for="exampleInputEmail1">sample_type <em>*</em></label>
                      <input type="text" class="form-control" required="required" name="sample_type" id="sample_type" placeholder="Enter Sample Type">
                    </div>
                    <div class="form-group">
                      <label for="exampleInputEmail1">Normal Range</label>
                      <input type="text" class="form-control" required="required" name="normal_range" id="normal_range" placeholder="Enter Normal Range">
                    </div>
                    <div class="form-group">
                      <label for="exampleInputEmail1">Units <em>*</em></label>
                      <input type="text" class="form-control" required="required" name="units" id="units" placeholder="Enter Units">
                    </div>
                    <div class="form-group">
                      <label for="exampleInputEmail1">Turnaround Time</label>
                      <input type="text" class="form-control" required="required" name="turnaround_time" id="turnaround_time" placeholder="Enter Turnaround Time">
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
<script type="text/javascript">
$(function(){
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