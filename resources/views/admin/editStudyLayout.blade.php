<a name="edit_layout_form"></a>
<div class="col-12 col-sm-6 col-md-12">
    <div class="card card-purple">
    <div class="card-header">
    <h3 class="card-title">Edit Layout Data</h3>
    </div>
    <!-- /.card-header -->
    <!-- form start -->
    <form name="edit_study_layout_form" id="edit_study_layout_form" method="post" action="">
        <input type="hidden" name="study_layout_id" id="study_layout_id" value="{{ $studyLayout->id }}">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Layout Name <em>*</em></label>
                        <input type="text" value="{{ $studyLayout->name }}" class="form-control" required="required" name="layout_name" id="layout_name" placeholder="Enter Layout Name">
                    </div>
                </div>
                @if($roleId != 4)
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Layout For <em>*</em></label>
                        <select class="form-control select2 doctor_id" required="required" name="doctor_id" id="doctor_id">
                            <option value="0" @if(empty($studyLayout->created_by))selected="selected"@endif>All Doctors</option>
                            @foreach($doctors as $doctor)
                            <option value="{{$doctor->user_id}}" @if($studyLayout->created_by == $doctor->user_id) selected="selected"@endif>{{$doctor->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                @else
                <input type="hidden" name="doctor_id" id="doctor_id" value="{{$authUser->id}}">
                @endif
            </div>      
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Modality <em>*</em></label>
                        <select class="form-control select2 modality" required="required" name="modality" id="modality_edit">
                            <option value="">Select Modality</option>
                            @foreach($modalityes as $modality)
                            <option value="{{$modality->id}}" @if($selectedModality == $modality->id) selected="selected" @endif>{{$modality->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Study <em>*</em></label>
                        <select class="form-control select2 study" required="required" name="study_id" id="study_id">
                            <option value="">Select Study</option>
                            @foreach($studies as $study)
                            <option value="{{$study->id}}" @if($selectedStudy == $study->id) selected="selected" @endif>{{$study->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                    <label for="layout">Layout <em>*</em></label>
                        <textarea id="layout" name="layout">{{ $studyLayout->layout }}</textarea>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
            <button type="button" id="update_btn" class="btn btn-success update_btn float-right">Update</button>
        </div>
    </form>
</div>
<!-- /.info-box -->
</div>
<script type="text/javascript">
    $(document).ready(function() {
        $('#layout').summernote();

        $('#update_btn').on('click', function() {
            const thisBtn = $(this);
            thisBtn.html('Updating <i class="fas fa-spinner fa-spin"></i>');
            $(".form-control").removeClass("is-invalid");
            $(".error").remove();
            var form_data = new FormData();
            var other_data = $('#edit_study_layout_form').serializeArray();
            $.each(other_data, function (key, input) {
                form_data.append(input.name, input.value);
            });
            
            $.ajax({
                url: '{{url("admin/update-study-layout")}}',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                type: 'post',
                success: function (data) {
                    thisBtn.html('Update');
                    if ($.isEmptyObject(data.error)) {
                        printSuccessMsg(data.success);
                        $('#edit_study_layout_form').trigger("reset");
                    } else {
                        printErrorMsg(data.error);
                    }
                },
                error: function (data) {
                    thisBtn.html('Update');
                }
            });
        });
    });
</script>