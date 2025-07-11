<style>
    .my-image-class {
        background-color: #6f42c1 !important;
        color: #fff !important;
    }
    .my-complete-class {
        background-color: #28a745!important;
        color: #fff !important;
    }
    .my-incomplete-class {
        background-color: #dc3545!important;
        color: #fff !important;
    }
</style>
<input type="hidden" id="unique_case_study_id" value="{{ $caseStudy->id }}" />
<div id="tabs">
    <ul>
        <li><a href="#tabs-images">Images</a></li>
        @if($roleId != '3')
            @foreach($caseStudy->study as $study)
                <li><a href="#tabs-{{ $study->id }}">CASE - {{ $study->type->name }}</a></li>
            @endforeach
        @endif
    </ul>
    <div id="tabs-images">
        <div class="row" style="padding: 10px; margin-bottom: 5px;">
            <div class="col-md-12" style="padding: 5px; margin-bottom: 10px; background-color: #e1e2e3; border: 1px solid #cacbcd;">
                <div style="width: 100%;  overflow-x: auto; white-space: nowrap;">
                    @foreach($caseStudy->images as $image)
                        <img src="{{ asset('storage/' . $image->image) }}" height="160px" style="padding:5px; cursor:pointer" class="image-thumb-doctor" />
                    @endforeach
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-2">
                <div class="card card-purple">
                    <div class="card-header">
                        <h3 class="card-title">Study Details</h3>
                    </div>
                    <div class="card-body">
                        @php $i = 1; @endphp
                        @foreach($caseStudy->study as $study)
                            <strong>Study @php echo $i++; @endphp </strong>@if($study->status=='1')<span class="right badge badge-success">Done</span> @else <span class="right badge badge-danger">Pending</span> @endif
                            <p class="text-muted">
                                <strong>Type: </strong>{{ $study->type->name }}
                            </p>
                            <p class="text-muted">
                                <strong>Description: </strong>{{ $study->description }}
                            </p>
                            <hr>
                        @endforeach
                    </div>
                </div>
                <div class="card card-purple">
                    <div class="card-header">
                        <h3 class="card-title">Patient Details</h3>
                    </div>
                    <div class="card-body">
                        <strong>Name:</strong>
                        <p class="text-muted">
                            {{ $caseStudy->patient->name }}
                        </p>
                        <strong>Age:</strong>
                        <p class="text-muted">
                            {{ $caseStudy->patient->age }}
                        </p>
                        <strong>Gender:</strong>
                        <p class="text-muted">
                            {{ ucwords($caseStudy->patient->gender) }}
                        </p>
                        <strong>Clinical History:</strong>
                        <p class="text-muted">
                            {{ ucwords($caseStudy->patient->clinical_history) }}
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-10">
                <div class="card card-purple card-outline">
                    <div class="card-body box-profile">
                        <img src="{{ asset('storage/' . $caseStudy->images[0]->image) }}" id="cropImage-doctor" style="max-width: 100%; width: 100%; padding:5px" />
                        <div class="crop-toolbar">
                            <button class="toolbar-btn" id="flipHorizontal-doctor" title="Flip Horizontal">
                                <i class="fas fa-arrows-alt-h"></i>
                            </button>
                            <button class="toolbar-btn" id="flipVertical-doctor" title="Flip Vertical">
                                <i class="fas fa-arrows-alt-v"></i>
                            </button>
                            <button class="toolbar-btn" id="moveLeft-doctor" title="Move Left">
                                <i class="fas fa-arrow-left"></i>
                            </button>
                            <button class="toolbar-btn" id="moveRight-doctor" title="Move Right">
                                <i class="fas fa-arrow-right"></i>
                            </button>
                            <button class="toolbar-btn" id="moveUp-doctor" title="Move Up">
                                <i class="fas fa-arrow-up"></i>
                            </button>
                            <button class="toolbar-btn" id="moveDown-doctor" title="Move Down">
                                <i class="fas fa-arrow-down"></i>
                            </button>
                            <button class="toolbar-btn" id="zoomOut-doctor" title="Zoom Out">
                                <i class="fas fa-search-minus"></i>
                            </button>
                            <button class="toolbar-btn" id="zoomIn-doctor" title="Zoom In">
                                <i class="fas fa-search-plus"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row" style="padding: 10px; margin-bottom: 5px;">
            <div class="col-md-12">
                <div class="card card-purple">
                    <div class="card-header">
                        <h3 class="card-title">Comments</h3>
                    </div>
                    <div class="card-body comments-section">
                    </div>
                </div>
            </div>
        </div>
    </div>
    @if($roleId != '3')
    @foreach($caseStudy->study as $study)
        <div id="tabs-{{ $study->id }}">
            <div class="row" style="padding: 10px; margin-bottom: 5px;">
                <div class="col-12 col-sm-6 col-md-12">
                    <div class="card card-purple">
                        <div class="card-header">
                            <h3 class="card-title">{{ $study->type->name }}</h3>
                        </div>
                        <form name="study_layout_view_form" class="study_layout_view_form">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Select Layout</label>
                                    <select class="form-control select2 doctor-layout-selector" data-index="{{ $study->id }}" id="layout-{{ $study->id }}" name="layout-{{ $study->id }}">
                                        @if($study->status == '1')
                                            <option value="0" selected="selected">Saved Report</option>
                                        @endif
                                        @if($caseStudy->study_status_id != '3')
                                            @foreach($study->type->layout as $layout)
                                                @if($layout->created_by == NULL or $layout->created_by == $authUser->id)
                                                    <option value="{{ $layout->id }}">{{ $layout->name }}</option>
                                                @endif
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Layout</label>
                                    <textarea class="layout-doctor" id="layout_{{ $study->id }}" name="layout">@if($study->status == '1') {{ $study->report }} @elseif(isset($study->type->layout[0])) {{ $study->type->layout[0]->layout }} @endif</textarea>
                                </div>
                                @if($caseStudy->study_status_id == '3')
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Status</label>
                                    <select id="qc_status_{{ $study->id }}" name="qc_status_{{ $study->id }}" class="form-control select2" style="width: 100%;">
                                        <option value="4">Re-Work</option>
                                        <option value="5" selected="selected">Complete</option>
                                    </select>
                                </div>
                                @endif
                                <div class="form-group">
                                    <button type="button" class="btn btn-success float-right save-study" id="save_btn_{{ $study->id }}" data-index="{{ $study->id }}" data-study-status-id="{{ $caseStudy->study_status_id }}">Save</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
    @endif
</div>
<script>
    $( function() {
        $( "#tabs" ).tabs();
        $('.layout-doctor').summernote({
            height: 300,
            fontNames: ['Arial', 'Arial Black', 'Comic Sans MS', 'Courier New', 'Merriweather'],
            fontNamesIgnoreCheck: ['Merriweather'],
            toolbar: [
            // [groupName, [list of button]]
            ['style', ['bold', 'italic', 'underline', 'clear']],
            ['font', ['strikethrough', 'superscript', 'subscript']],
            ['fontname', ['fontname']],
            ['fontsize', ['fontsize']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['height', ['height']]
            ]
        });
        $('#tabs ul li a[href="#tabs-images"]').addClass('my-image-class');
        @foreach($caseStudy->study as $study)
            @if($study->status == '1')
                $('#tabs ul li a[href="#tabs-{{ $study->id }}"]').addClass('my-complete-class');
            @else
                $('#tabs ul li a[href="#tabs-{{ $study->id }}"]').addClass('my-incomplete-class');
            @endif
        @endforeach

        $.ajax({
            url: "{{ route('admin.getCaseComments') }}",
            type: "POST",
            data: {
                "_token": "{{ csrf_token() }}",
                "case_study_id": $('#unique_case_study_id').val()
            },
            success: function (response) {
                $('.comments-section').html(response);
            }
        });

        $(document).on('change', '.doctor-layout-selector', function() {
            var layoutId = $(this).val();
            var studyId = $(this).data('index');
            
            $.ajax({
                url: "{{ route('admin.getLayout') }}",
                type: "POST",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "layout_id": layoutId,
                    "study_id": studyId
                },
                success: function (response) {
                    $('#layout_'+studyId).summernote('code', response);
                }
            });
        });

        $('#doc_image_view').on('shown.bs.modal', function () {
            $('.save-study').off('click').on('click', function () {
                $(this).html('Saving <i class="fas fa-spinner fa-spin"></i>');
                var studyId = $(this).data('index');
                var layout = $('#layout_' + studyId).val();
                var qcStatus = $('#qc_status_' + studyId).val();
                var status_id = $(this).data('study-status-id');

                var msg = 'You want to save this Case with all the studies?';
                if(status_id < 3){
                    msg = 'You want to save this Study?';
                }

                Swal.fire({
                    icon: 'warning',
                    title: "Are you sure?",
                    text: msg,
                    showCancelButton: true,
                    confirmButtonText: "Yes, Save it!",
                    cancelButtonText: "No, Cancel!",
                    showLoaderOnConfirm: true
                }).then((result) => {
                    if(result.isConfirmed === true){
                        $.ajax({
                            url: "{{ route('admin.saveCaseSingleStudy') }}",
                            type: "POST",
                            data: {
                                "_token": "{{ csrf_token() }}",
                                "study_id": studyId,
                                "layout": layout,
                                "qc_status": qcStatus
                            },
                            success: function (data) {
                                $('.save-study').html('Save');
                                if ($.isEmptyObject(data.error)) {
                                    if(status_id < 3){
                                        swal.fire({
                                            icon: 'success',
                                            title: "Data Saved.",
                                            text: data.success,
                                            showConfirmButton: true,
                                        });
                                    }
                                    else{
                                        printSuccessMsg(data.success);
                                    }
                                } else {
                                    printErrorMsg(data.error);
                                }
                            }
                        });
                    }
                    else{
                        $('.save-study').html('Save');
                    }
                });
            });
        });
    });
</script>