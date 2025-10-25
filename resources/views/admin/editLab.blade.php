<a name="edit_form"></a>
<div class="col-12 col-sm-6 col-md-12">
    <div class="card card-purple">
        <div class="card-header">
            <h3 class="card-title">Edit {{$labratory->lab_name}}'s Data</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
        <form name="laboratory_form" id="laboratory_form" method="post" action="">
            <div class="card-body">
                <div class="form-group">
                    <label for="exampleInputEmail1">Centre Name <em>*</em></label>
                    <input type="text" value="{{$labratory->lab_name}}" class="form-control" required="required" name="lab_name" id="lab_name" placeholder="Enter Lab Name">
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Centre Login Email <em>*</em></label>
                    <input type="text" value="{{$labratory->user->email}}" class="form-control" required="required" name="lab_login_email" id="lab_login_email" placeholder="Lab Login Email" disabled>
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Centre Primary Location <em>*</em></label>
                    <input type="text" value="{{$labratory->lab_primary_location}}" class="form-control" required="required" name="lab_primary_location" id="lab_primary_location" placeholder="Lab Primary Location">
                </div>
                <div class="form-group">
                    <label for="exampleInputCentrePhoneNumber">Centre Phone Number<em>*</em></label>
                    <input type="text" value="{{$labratory->lab_phone_number}}" class="form-control" required="required" name="lab_phone_number" id="lab_phone_number" placeholder="Lab Phone Number">
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Modality <em>*</em></label>
                    <select class="form-control select2" required="required" multiple="multiple" name="modality[]" id="modality">
                        @foreach($modalityes as $modality)
                        <option value="{{$modality->id}}" @if(in_array($modality->id, $labModalityArray)) selected="selected" @endif>{{$modality->name}}</option>
                        @endforeach
                    </select>
                </div>
                @include('admin.includes.extra_fields_edit')
            </div>
            <!-- /.card-body -->

            <div class="card-footer">
                <button type="button" id="update_btn" data-id="{{$labratory->id}}" class="btn btn-warning float-right update_btn">Update</button>
            </div>
        </form>
    </div>
    <!-- /.info-box -->
</div>
<script type="text/javascript">
    $(function () {
        $('.select2').select2({
            theme: 'bootstrap4',
            placeholder: '-- Select Modality --',
            templateSelection: function (data, container) {
                $(container).addClass('bg-purple');
                return data.text;
            },
            closeOnSelect: false
        });
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
        @if(isset($formFields))
          @foreach ($formFields as $formField)
            @if($formField->FormField->element_type == "multiselect")
              $('#{{$formField->FormField->field_name}}').select2();
            @elseif($formField->FormField->element_type == "phone")
              $('#{{$formField->FormField->field_name}}').inputmask({
                mask: "9999-999-999",
                prefix: "+91 ",
                placeholder: "____-___-___",           // Optional: use space as placeholder
                showMaskOnHover: true,      // Don't show mask when not focused
                showMaskOnFocus: true,       // Show mask on focus
                onincomplete: function () {
                    $(this).val('');         // Clear field if input is incomplete
                }
              });
            @elseif($formField->FormField->element_type == "date")
              $('#{{$formField->FormField->field_name}}').daterangepicker({
                singleDatePicker: true,
                locale: {
                  format: 'DD/MM/YYYY'
                }
              });
            @elseif($formField->FormField->element_type == "datetime")
              $('#{{$formField->FormField->field_name}}').daterangepicker({
                  singleDatePicker: true,
                  timePicker: true,
                  timePickerIncrement: 30,
                  locale: {
                    format: 'DD/MM/YYYY hh:mm A'
                  }
                });
            @endif
          @endforeach
        @endif
        $("#update_btn").on('click', function () {
            $(this).html('Updating <i class="fas fa-spinner fa-spin"></i>');
            $(".form-control").removeClass("is-invalid");
            $(".error").remove();
            var form_data = new FormData();
            var other_data = $('#laboratory_form').serializeArray();
            var lab_id = $(this).data("id");
            $.each(other_data, function (key, input) {
                form_data.append(input.name, input.value);
            });
            form_data.append("lab_id", lab_id);

            $.ajax({
                url: '{{url("admin/update-laboratory")}}',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                type: 'post',
                success: function (data) {
                    $('#update_btn').html('Update');
                    if ($.isEmptyObject(data.error)) {
                        printSuccessMsg(data.success);
                        $('#laboratory_form').trigger("reset");
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