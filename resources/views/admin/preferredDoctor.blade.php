<a name="preferred-doc"></a>
<div class="col-12 col-sm-6 col-md-12">
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">{{$lab->lab_name}}'s Preferred Doctors</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
        <form name="praferred_doctors" id="praferred_doctors" method="post" action="">
            <input type="hidden" name="lab_id" value="{{$lab->id}}">
            <div class="card-body">
                @foreach($modalities as $modality)
                    @php $selected_doctor = ""; @endphp
                    @foreach($preferredDoctors as $preferredDoctor)
                        @if($preferredDoctor->modality_id == $modality->id)
                            @php
                                $selected_doctor = $preferredDoctor->doctor_id;
                            @endphp
                        @endif
                    @endforeach
                <div class="form-group">
                    <label for="exampleInputEmail1">Select Doctor For {{$modality->name}}</label>
                    <select class="form-control" required="required" data-modality_id="{{ $modality->id }}" id="modality_{{ $modality->id }}" name="modality_{{ $modality->id }}">
                        <option value="">Select Doctor</option>
                        @foreach($modality->doctor as $doc)
                            <option value="{{$doc->id}}" @if($selected_doctor == $doc->id) selected="selected" @endif>{{$doc->name}}</option>
                        @endforeach
                    </select>
                </div>
                @endforeach
            </div>
            <!-- /.card-body -->

            <div class="card-footer">
                <button type="button" id="update_praferred_btn" data-id="{{$lab->id}}" class="btn btn-warning float-right update_btn">Update</button>
            </div>
        </form>
    </div>
    
    <div class="card card-danger">
        <div class="card-header">
            <h3 class="card-title">{{$lab->lab_name}}'s Black Listed Doctors</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
        <form name="black_listed_doctors" id="black_listed_doctors" method="post" action="">
            <input type="hidden" name="lab_id" value="{{$lab->id}}">
            <div class="card-body">
                <div class="form-group">
                    <label for="exampleInputEmail1">Black List Doctor For {{$lab->lab_name}}</label>
                    <select class="form-control select2" required="required" multiple="multiple" name="doctors[]" id="blacklisted_doctors">
                        <option value="">Select Doctor</option>
                        @foreach($doctors as $doc)
                            <option value="{{$doc->id}}" @if(in_array($doc->id, $labBlackListedDoctorIds)) selected="selected" @endif @if(in_array($doc->id, $preferredDoctorIds)) disabled="disabled" @endif>{{$doc->name}} @if(in_array($doc->id, $preferredDoctorIds)) (Disabled) @endif</option>
                        @endforeach
                    </select>
                </div>
            <!-- /.card-body -->

                <div class="card-footer">
                    <button type="button" id="update_black_list_btn" class="btn btn-warning float-right update_btn">Update</button>
                </div>
            </div>
        </form>
    </div>

    <!-- /.info-box -->
</div>

<script type="text/javascript">
    $(function () {
        $select = $('.select2').select2({
            theme: 'bootstrap4',
            placeholder: '-- Select Doctors --',
            templateSelection: function (data, container) {
                $(container).addClass('bg-danger');
                return data.text;
            },
            closeOnSelect: false
        });

        $('#update_praferred_btn').click(function () {
            $('#update_praferred_btn').html('Updating...');
            var form_data = new FormData($('#praferred_doctors')[0]);
            
            $.ajax({
                url: '{{url("admin/update-preferred-doctors")}}',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                type: 'post',
                success: function (data) {
                    $('#update_praferred_btn').html('Update');
                    if ($.isEmptyObject(data.error)) {
                        printSuccessMsg(data.success);
                        $('#praferred_doctors').trigger("reset");
                    } else {
                        printErrorMsg(data.error);
                    }
                },
                error: function (data) {
                    $('#update_praferred_btn').html('Update');
                }
            });
        });

        $("#update_black_list_btn").click(function(){
            $('#update_black_list_btn').html('Updating...');
            var form_data = new FormData($('#black_listed_doctors')[0]);
            
            $.ajax({
                url: '{{url("admin/update-black-listed-doctors")}}',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                type: 'post',
                success: function (data) {
                    $('#update_black_list_btn').html('Update');
                    if ($.isEmptyObject(data.error)) {
                        printSuccessMsg(data.success);
                        $('#black_listed_doctors').trigger("reset");
                    } else {
                        printErrorMsg(data.error);
                    }
                },
                error: function (data) {
                    $('#update_black_list_btn').html('Update');
                }
            });
        });
    });
</script>