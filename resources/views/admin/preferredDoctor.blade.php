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
            <div class="card-body">
                @foreach($modalities as $modality) 
                <div class="form-group">
                    <label for="exampleInputEmail1">Select Doctor For {{$modality->name}}</label>
                    <select class="form-control" required="required" id="modality">
                        <option value="">Select Doctor</option>
                        @foreach($modality->doctor as $doc)
                            <option value="{{$doc->id}}">{{$doc->name}}</option>
                        @endforeach
                    </select>
                </div>
                @endforeach
            </div>
            <!-- /.card-body -->

            <div class="card-footer">
                <button type="button" id="update_btn" data-id="{{$lab->id}}" class="btn btn-warning float-right update_btn">Update</button>
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
            <div class="card-body">
                <div class="form-group">
                    <label for="exampleInputEmail1">Black List Doctor For {{$lab->lab_name}}</label>
                    <select class="form-control select2" required="required" multiple="multiple" name="blacklisted_doctors[]" id="blacklisted_doctors">
                        <option value="">Select Doctor</option>
                        @foreach($doctors as $doc)
                            <option value="{{$doc->id}}">{{$doc->name}}</option>
                        @endforeach
                    </select>
                </div>
            <!-- /.card-body -->

                <div class="card-footer">
                    <button type="button" id="update_btn" data-id="{{$lab->id}}" class="btn btn-warning float-right update_btn">Update</button>
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
    });
</script>