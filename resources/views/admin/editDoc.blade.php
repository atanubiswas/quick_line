<a name="edit_form"></a>
<div class="col-12 col-sm-6 col-md-12">
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Edit {{$doctor->doc_name}}'s Data</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
        <form name="doctor_form" id="doctor_form" method="post" action="">
            <div class="card-body">
                <div class="form-group">
                    <label for="exampleInputEmail1">Doctor's Name <em>*</em></label>
                    <input type="text" value="{{$doctor->doc_name}}" class="form-control" required="required" name="doc_name" id="doc_name" placeholder="Enter Doctor's Name">
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Doctor's Login Email <em>*</em></label>
                    <input type="text" value="{{$doctor->doc_login_email}}" class="form-control" required="required" name="doc_login_email" id="doc_login_email" placeholder="Doctor's Login Email" disabled>
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Doctor's Primary Location <em>*</em></label>
                    <input type="text" value="{{$doctor->doc_primary_location}}" class="form-control" required="required" name="doc_primary_location" id="doc_primary_location" placeholder="Doctor's Primary Location">
                </div>
                @foreach ($formFields as $formField)
                @php
                $value = "";
                @endphp
                @foreach($doctor->docFormFieldValue as $formFieldValue)
                @if($formField->id == $formFieldValue->form_field_id)
                @php
                $value = $formFieldValue->value;
                break;
                @endphp
                @endif
                @endforeach
                @include("admin.includes.extra_fields_edit")
                @endforeach
            </div>
            <!-- /.card-body -->

            <div class="card-footer">
                <button type="button" id="update_btn" data-id="{{$doctor->id}}" class="btn btn-primary update_btn">Update</button>
            </div>
        </form>
    </div>
    <!-- /.info-box -->
</div>
<script type="text/javascript">
    $(function () {
        $("#update_btn").on('click', function () {
            $(this).html('Updating <i class="fas fa-spinner fa-spin"></i>');
            $(".form-control").removeClass("is-invalid");
            $(".error").remove();
            var form_data = new FormData();
            var other_data = $('#doctor_form').serializeArray();
            var doc_id = $(this).data("id");
            $.each(other_data, function (key, input) {
                form_data.append(input.name, input.value);
            });
            form_data.append("doc_id", doc_id);
            
            $.ajax({
                url: '{{url("admin/update-doctor")}}',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                type: 'post',
                success: function (data) {
                    $('#update_btn').html('Update');
                    if ($.isEmptyObject(data.error)) {
                        printSuccessMsg(data.success);
                        $('#doctor_form').trigger("reset");
                    } else {
                        printErrorMsg(data.error);
                    }
                },
                error: function (data) {
                    $('#update_btn').html('Update');
                }
            });
        });
    });
</script>