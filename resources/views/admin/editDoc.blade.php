<a name="edit_form"></a>
<div class="col-12 col-sm-6 col-md-12">
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Edit {{$doctor->name}}'s Data</h3>
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
                    <label for="exampleInputEmail1">Name <em>*</em></label>
                    <input type="text" value="{{$doctor->name}}" class="form-control" required="required" name="name" id="name" placeholder="Name">
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Login Email <em>*</em></label>
                    <input type="text" value="{{$doctor->email}}" class="form-control" required="required" name="login_email" id="login_email" placeholder="Login Email" disabled>
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Phone Number <em>*</em></label>
                    <input type="text" value="{{$doctor->phone_number}}" class="form-control" required="required" name="phone_number" id="phone_number" placeholder="Phone Number">
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Modality <em>*</em></label>
                    <select class="form-control select2" required="required" multiple="multiple" name="modality[]" id="modality">
                        @foreach($modalityes as $modality)
                        <option value="{{$modality->id}}" @if(in_array($modality->id, $docModalityArray)) selected="selected" @endif>{{$modality->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="current_signature">Current Signature</label>
                            <img src="{{url('storage/'.$doctor->signature)}}" alt="Current Signature" class="img-fluid" style="width: 250px;">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="doctor_signature">Update Signature <em>*</em></label>
                            <input type="file" class="form-control"  accept="image/*" required="required" name="doctor_signature" id="doctor_signature" accept=".png, .jpg, .jpeg">
                        </div>
                    </div>
                </div>
                
                @include('admin.includes.extra_fields_edit')
            </div>
            <!-- /.card-body -->

            <div class="card-footer">
                <button type="button" id="update_btn" data-id="{{$doctor->id}}" class="btn btn-warning float-right update_btn">Update</button>
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
        $('#phone_number').inputmask({
            mask: "9999-999-999",
            prefix: "+91 ",
            placeholder: "____-___-___",           // Optional: use space as placeholder
            showMaskOnHover: true,      // Don't show mask when not focused
            showMaskOnFocus: true,       // Show mask on focus
            onincomplete: function () {
                $(this).val('');         // Clear field if input is incomplete
            }
        });
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

            var fileInput = $('#doctor_signature')[0];
            if (fileInput.files.length > 0) {
                form_data.append('doctor_signature', fileInput.files[0]);
            }
            
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