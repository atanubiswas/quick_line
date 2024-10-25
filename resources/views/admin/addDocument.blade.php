@extends('layouts.admin_layout')
@section('title', "Upload Laboratory Document")
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
                            <h3 class="card-title">Add {{$pageName}}</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form name="laboratory_form" id="laboratory_form" method="post" action="" enctype="multipart/form-data">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Document Type <em>*</em></label>
                                    <input type="text" class="form-control" required="required" name="document_type" id="document_type" placeholder="Enter Document Type">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Document Number <em>*</em></label>
                                    <input type="text" class="form-control" required="required" name="document_number" id="document_number" placeholder="Enter Document Number">
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="documentFrontImage">Document Front Image <em>*</em></label>
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input type="file" accept="image/*" required="required" class="custom-file-input" id="document_front_image" name="document_front_image" onchange="previewImage('document_front_image', 'documentFrontPreview', 'documentFrontPreviewDiv')">
                                                    <label class="custom-file-label" for="documentFrontImage">Choose file</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6" id="documentFrontPreviewDiv" style="display: none">
                                        <div class="form-group">
                                            <label>Document Front Image Preview:</label>
                                            <img id="documentFrontPreview" src="#" alt="Document Front Image Preview" style="width: 250px; display: none;">
                                            <button type="button" class="btn btn-sm btn-danger rounded-circle" onclick="removeImage('document_front_image', 'documentFrontPreview', 'documentFrontPreviewDiv')" style="position: absolute; top: 35px; left: 225px; width: 30px; height: 30px; padding: 0; border-radius: 50%;">X</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="documentBackImage">Document Back Image</label>
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input type="file" accept="image/*" class="custom-file-input" id="document_back_image" name="document_back_image" onchange="previewImage('document_back_image', 'documentBackPreview', 'documentBackPreviewDiv')">
                                                    <label class="custom-file-label" for="documentBackImage">Choose file</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6" id="documentBackPreviewDiv" style="display: none">
                                        <div class="form-group">
                                            <label>Document Back Image Preview:</label>
                                            <img id="documentBackPreview" src="#" alt="Document Back Image Preview" style="width: 250px; display: none;">
                                            <button type="button" class="btn btn-sm btn-danger rounded-circle" onclick="removeImage('document_back_image', 'documentBackPreview', 'documentBackPreviewDiv')" style="position: absolute; top: 35px; left: 225px; width: 30px; height: 30px; padding: 0; border-radius: 50%;">X</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Document Start Date</label>
                                            <div class="input-group date" id="document_start_date" data-target-input="nearest">
                                                <input type="text" required="required" id="document_start_date" name="document_start_date" class="form-control datetimepicker-input" data-target="#document_start_date" placeholder="Enter Document's Start Date">
                                                <div class="input-group-append" data-target="#document_start_date" data-toggle="datetimepicker">
                                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Document End Date</label>
                                            <div class="input-group date" id="document_end_date" data-target-input="nearest">
                                                <input type="text" required="required" id="document_end_date" name="document_end_date" class="form-control datetimepicker-input" data-target="#document_end_date" placeholder="Enter Document's End Date">
                                                <div class="input-group-append" data-target="#document_end_date" data-toggle="datetimepicker">
                                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
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
$(function () {
    $('#document_start_date').datetimepicker({
        format: 'DD/MM/YYYY'
    });
    $('#document_end_date').datetimepicker({
        format: 'DD/MM/YYYY'
    });
    $('#save_btn').on('click', function () {
        $(this).html('Saving <i class="fas fa-spinner fa-spin"></i>');
        var form_data = new FormData($('#laboratory_form')[0]);
        $(".form-control").removeClass("is-invalid");
        $(".error").remove();
        $.ajax({
            url: '{{url("admin/upload-document")}}',
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

function previewImage(inputId, previewId, previewDivId) {
    var input = document.getElementById(inputId);
    var preview = document.getElementById(previewId);
    var previewDiv = document.getElementById(previewDivId);

    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.style.display = 'block';
            previewDiv.style.display = 'block';
        }
        reader.readAsDataURL(input.files[0]);
    }
}

function removeImage(inputId, previewId, previewDivId) {
    var input = document.getElementById(inputId);
    var preview = document.getElementById(previewId);
    var previewDiv = document.getElementById(previewDivId);

    // Clear the image preview
    preview.src = '#';

    // Hide the preview div
    previewDiv.style.display = 'none';

    // Clear the file input value
    input.value = '';
}
</script>
@endsection