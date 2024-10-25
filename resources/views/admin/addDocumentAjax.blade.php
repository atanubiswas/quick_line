<a name="add_document"></a>
<div class="col-12 col-sm-6 col-md-12">
    <div class="card card-purple">
        <div class="card-header">
            <h3 class="card-title">Add {{$labratory->lab_name}}'s Document</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
        <form name="laboratory_form" id="document_form" method="post" action="" enctype="multipart/form-data">
            <input type="hidden" name="lab_id" id="lab_id" value="{{$labratory->id}}" />
            <input type="hidden" name="user_id" id="user_id" value="{{$labratory->user_id}}" />
            <div class="card-body">
                <div class="form-group">
                    <label for="exampleInputEmail1">Document Type <em>*</em></label>
                    <input type="text" class="form-control" required="required" name="document_type" id="document_type"
                        placeholder="Enter Document Type">
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Document Number <em>*</em></label>
                    <input type="text" class="form-control" required="required" name="document_number"
                        id="document_number" placeholder="Enter Document Number">
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="documentFrontImage">Document Front Image <em>*</em></label>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" accept="image/*" required="required" class="custom-file-input"
                                        id="document_front_image" name="document_front_image"
                                        onchange="previewImage('document_front_image', 'documentFrontPreview', 'documentFrontPreviewDiv')">
                                    <label class="custom-file-label" for="documentFrontImage">Choose file</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6" id="documentFrontPreviewDiv" style="display: none">
                        <div class="form-group">
                            <label>Document Front Image Preview:</label>
                            <img id="documentFrontPreview" src="#" alt="Document Front Image Preview"
                                style="width: 250px; display: none;">
                            <button type="button" class="btn btn-sm btn-danger rounded-circle"
                                onclick="removeImage('document_front_image', 'documentFrontPreview', 'documentFrontPreviewDiv')"
                                style="position: absolute; top: 35px; left: 225px; width: 30px; height: 30px; padding: 0; border-radius: 50%;">X</button>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="documentBackImage">Document Back Image</label>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" accept="image/*" class="custom-file-input"
                                        id="document_back_image" name="document_back_image"
                                        onchange="previewImage('document_back_image', 'documentBackPreview', 'documentBackPreviewDiv')">
                                    <label class="custom-file-label" for="documentBackImage">Choose file</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6" id="documentBackPreviewDiv" style="display: none">
                        <div class="form-group">
                            <label>Document Back Image Preview:</label>
                            <img id="documentBackPreview" src="#" alt="Document Back Image Preview"
                                style="width: 250px; display: none;">
                            <button type="button" class="btn btn-sm btn-danger rounded-circle"
                                onclick="removeImage('document_back_image', 'documentBackPreview', 'documentBackPreviewDiv')"
                                style="position: absolute; top: 35px; left: 225px; width: 30px; height: 30px; padding: 0; border-radius: 50%;">X</button>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Document Start Date</label>
                            <div class="input-group date" id="document_start_date_div" data-target-input="nearest">
                                <input type="text" required="required" id="document_start_date"
                                    name="document_start_date" class="form-control datetimepicker-input"
                                    data-target="#document_start_date" placeholder="Enter Document's Start Date">
                                <div class="input-group-append" data-target="#document_start_date"
                                    data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Document End Date</label>
                            <div class="input-group date" id="document_end_date_div" data-target-input="nearest">
                                <input type="text" required="required" id="document_end_date" name="document_end_date"
                                    class="form-control datetimepicker-input" data-target="#document_end_date"
                                    placeholder="Enter Document's End Date">
                                <div class="input-group-append" data-target="#document_end_date"
                                    data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.card-body -->

            <div class="card-footer">
                <button type="button" id="document_save_btn" class="btn btn-success document_save_btn float-right">Save</button>
            </div>
        </form>
        <div class="card-footer"></div>
    </div>
    <!-- /.info-box -->
</div>
<script type="text/javascript">
    $(function () {
        $('#document_start_date').daterangepicker({
            singleDatePicker: true,
            showDropdowns: true,
            autoUpdateInput: false,
            locale: {
                format: 'DD/MM/YYYY',
                cancelLabel: 'Clear'
            }
        });

        $('#document_end_date').daterangepicker({
            singleDatePicker: true,
            showDropdowns: true,
            autoUpdateInput: false,
            locale: {
                format: 'DD/MM/YYYY',
                cancelLabel: 'Clear'
            }
        });

        $('#document_save_btn').on('click', function () {
            $(this).html('Saving <i class="fas fa-spinner fa-spin"></i>');
            var form_data = new FormData($('#document_form')[0]);
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
                    $('#document_save_btn').html('Save');
                    if ($.isEmptyObject(data.error)) {
                        printSuccessMsg(data.success);
                        $('#laboratory_form').trigger("reset");
                    } else {
                        printErrorMsg(data.error);
                    }
                },
                error: function (data) {
                    $('#document_save_btn').html('Save');
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