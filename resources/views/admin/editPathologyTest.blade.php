<a name="edit_form"></a>
<div class="col-12 col-sm-6 col-md-12">
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Edit {{$pathologyTest->test_name}}</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
        <form name="pathology_test_form" id="pathology_test_form" method="post" action="">
        <div class="card-body">
            <div class="form-group">
                <label for="exampleInputEmail1">Test Name <em>*</em></label>
                <input type="text" value="{{$pathologyTest->test_name}}" class="form-control" required="required" name="test_name" id="test_name" placeholder="Enter Test Name">
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Test Code <em>*</em></label>
                <input type="text" value="{{$pathologyTest->test_code}}" class="form-control" required="required" name="test_code" id="test_code" placeholder="Enter Test Code">
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Select Category <em>*</em></label>
                <select class="form-control" required="required" name="pathology_test_categorie_id" id="pathology_test_categorie_id">
                    <option value="" selected="selected">Select Category</option>
                    @foreach($pathologyCategory as $category)
                    <option value="{{$category->id}}" @if($pathologyTest->pathology_test_categorie_id == $category->id) selected="selected" @endif>{{$category->category_name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Description</label>
                <textarea class="form-control" name="description" id="description" placeholder="Enter Test Description">{{$pathologyTest->description}}</textarea>
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Test Price <em>*</em></label>
                <input type="text" value="{{$pathologyTest->price}}" class="form-control" required="required" name="price" id="price" placeholder="Enter Test Price">
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">sample_type <em>*</em></label>
                <input type="text" value="{{$pathologyTest->sample_type}}" class="form-control" required="required" name="sample_type" id="sample_type" placeholder="Enter Sample Type">
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Normal Range</label>
                <input type="text" value="{{$pathologyTest->normal_range}}" class="form-control" required="required" name="normal_range" id="normal_range" placeholder="Enter Normal Range">
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Units <em>*</em></label>
                <input type="text" value="{{$pathologyTest->units}}"class="form-control" required="required" name="units" id="units" placeholder="Enter Units">
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Turnaround Time</label>
                <input type="text" value="{{$pathologyTest->turnaround_time}}" class="form-control" required="required" name="turnaround_time" id="turnaround_time" placeholder="Enter Turnaround Time">
            </div>
        </div>
        <!-- /.card-body -->

            <div class="card-footer">
                <button type="button" id="update_btn" data-id="{{$pathologyTest->id}}" class="btn btn-primary update_btn">Update</button>
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
            var other_data = $('#pathology_test_form').serializeArray();
            var pathology_test_id = $(this).data("id");
            $.each(other_data, function (key, input) {
                form_data.append(input.name, input.value);
            });
            form_data.append("pthology_test_id", pathology_test_id);
            
            $.ajax({
                url: '{{url("admin/update-pathology-test")}}',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                type: 'post',
                success: function (data) {
                    $('#update_btn').html('Update');
                    if ($.isEmptyObject(data.error)) {
                        printSuccessMsg(data.success);
                        $('#pathology_test_form').trigger("reset");
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