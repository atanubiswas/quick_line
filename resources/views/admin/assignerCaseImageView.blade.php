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
        <li><a href="#tabs-images" class="my-image-class">Existing Images</a></li>
        @if(in_array($roleId, [1,5,6]))
            <li><a href="#tabs-edit-case" class="my-complete-class">Edit Case Study</a></li>
        @endif
    </ul>
    <div id="tabs-images">
    @if($caseStudy->study_status_id <=2)
        <div class="row">
            <div class="col-sm-12">
                <div class="form-group">
                    <div class="upload-container">
                        <!-- Browse Files Button -->
                        <label for="existingUploadImages" class="upload-btn">
                            <i class="fas fa-folder-open"></i> Add More Image
                        </label>
                        <input type="file" id="existingUploadImages" multiple="multiple" accept="image/*" hidden>
                    </div>
                </div>
            </div>
        </div>
        @endif
        <div class="row" style="padding: 10px; margin-bottom: 5px;">
            <div class="col-md-12" style="padding: 5px; margin-bottom: 10px; background-color: #e1e2e3; border: 1px solid #cacbcd;">
                <div class="existing-image-contener" style="width: 100%;  overflow-x: auto; white-space: nowrap;">
                    @php $existingImageCount = 0; @endphp
                    @foreach($caseStudy->images as $image)
                        <div class="m-2 position-relative d-inline-block" id="existing-img-preview-{{ $existingImageCount }}">
                            <img src="{{ asset('storage/' . $image->image) }}" data-file-index="{{ $existingImageCount }}" id="existing_image_{{ $existingImageCount }}" height="160px" style="padding:5px; cursor:pointer" class="image-thumb-assigner" />
                            <button type="button"class="existing-img-close-btn btn btn-danger btn-sm" data-index="{{ $existingImageCount++ }}" style="position: absolute; top: 5px; right: 5px; border-radius: 30px; height: 20px; width: 20px; display: flex; justify-content: center; align-items: center; padding: 0; font-size: 14px; "> × </button>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card card-purple card-outline">
                    <div class="card-body box-profile">
                        <img src="{{ asset('storage'.DIRECTORY_SEPARATOR . $caseStudy->images[0]->image) }}" id="cropImage-assigner" style="max-width: 100%; width: 100%; padding:5px" />
                        <div class="crop-toolbar">
                            <!-- <div id="rotation-wheel" class="rotation-wheel-class">
                                <div class="main-line"></div>
                                <div class="small-lines"></div>
                            </div> -->
                            
                            <!-- Manual Rotation Input -->
                            <input type="number" id="rotation-angle" class="rotation-input" min="0" max="360" value="0">
                            <button class="toolbar-btn" id="flipHorizontal-doctor" title="Flip Horizontal">
                                <i class="fas fa-arrows-alt-h"></i>
                            </button>
                            <button class="toolbar-btn" id="flipVertical-doctor" title="Flip Vertical">
                                <i class="fas fa-arrows-alt-v"></i>
                            </button>
                            <button class="toolbar-btn" id="crop" title="Crop">
                                    <i class="fas fa-crop"></i>
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
                            @if($caseStudy->study_status_id <=2)
                            <button class="btn btn-success btn-sm save_this_image" id="save_this_image" style="margin-top: 10px;">Save This Image</button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @if($caseStudy->study_status_id <=2)
        <div class="row">
            <div class="col-md-12">
                <button class="btn btn-warning float-right" id="update_study_image" data-index="{{ $caseStudy->id }}">Update Images</button>
            </div>
        </div>
        @endif
    </div>
    @if(in_array($roleId, [1,5,6]))
    <div id="tabs-edit-case">
    <form method="post" id="existing_case_study_form" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-md-7">
                <div class="form-group">
                    <label for="centre">Centre Name</label>
                    <label class="form-control" style="cursor: not-allowed;"> {{ $caseStudy->laboratory->lab_name }}</label>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="modality">Referred by</label>
                    <input value="{{ $caseStudy->ref_by }}" type="text" name="ref_by" id="ref_by" class="form-control" placeholder="Enter Referred By">
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label for="modality">Select Modality <em>*</em></label>
                    <span class="form-control" style="cursor: not-allowed;">{{ $caseStudy->modality->name }}</span>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-7">
                <div class="form-group">
                    <label for="patient_name">Patient Name <em>*</em></label>
                    <input type="text" value="{{ $caseStudy->patient->name }}" name="patient_name" id="patient_name" class="form-control" placeholder="Enter Patient Name">
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label for="age">Age <em>*</em></label>
                    <input type="text" value="{{ $caseStudy->patient->age }}" name="age" id="age" class="form-control" placeholder="Enter Age">
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="gender">Gender <em>*</em></label>
                    <select name="gender" id="gender" class="form-control" style="width: 100%;">
                        <option value="">Select Gender</option>
                        <option @if($caseStudy->patient->gender == 'male') Selected @endif value="male">Male</option>
                        <option @if($caseStudy->patient->gender == 'female') Selected @endif value="female">Female</option>
                        <option @if($caseStudy->patient->gender == 'other') Selected @endif value="other">Other</option>
                    </select>
                </div>
            </div>
        </div>
        <span style="font-weight: 700;">Current Studie(s)</span>
        <div class="current-study-section">
            @foreach($caseStudy->study as $study)
                <div class="row position-relative mb-3 p-2 border rounded existing-study-block" style="background-color: #f9f9f9;">
                    <div class="col-md-5">
                        <div class="form-group">
                            <label for="patient_id">Study Name</label>
                            <select name="existing_study_id" class="form-control existing_study_id">
                                @foreach($studyTypes as $studyType)
                                    <option @if($studyType->id == $study->type->id) selected @endif value="{{ $studyType->id }}">{{ $studyType->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="form-group">
                            <label for="existing_desc">Description</label>
                            <textarea name="existing_desc" class="form-control existing_desc">{{ $study->description }}</textarea>
                        </div>
                    </div>
                    @if($caseStudy->study_status_id <= 2 )
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="patient_id">&nbsp;</label>
                            <div>
                                <button type="button" class="btn btn-warning btn-sm update-existing-study" data-index="{{ $study->id }}">Update</button>
                                <button type="button" class="btn btn-danger btn-sm remove-existing-study" data-index="{{ $study->id }}" data-value="{{ $study->type->name }}">Delete</button>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            @endforeach
        </div>

        @if($caseStudy->study_status_id <= 2 )
        <span style="font-weight: 700;">Add More Studie(s)</span>
        <div id="assigner-study-sections">
            <div class="assigner-study-section">
                <div class="row">
                    <div class="col-sm-5">
                        <div class="form-group">
                            <label for="study">Study <em>*</em></label>
                            <select name="study_id" class="form-control" id="add_study_type_id">
                                <option value="" selected>Select Study</option>
                                @foreach($studyTypes as $studyType)
                                    <option value="{{ $studyType->id }}">{{ $studyType->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-5">
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea name="description" class="form-control" id="add_study_desc" placeholder="Enter Description"></textarea>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="patient_id">&nbsp;</label>
                            <div>
                                <button type="button" class="btn btn-success btn-sm add-existing-study">Add</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
        <div class="row">
            <div class="col-sm-12">
                <div class="form-group">
                    <label for="history">Clinical History <em>*</em></label>
                    <textarea name="clinical_history" id="clinical_history" class="form-control" placeholder="Enter Clinical History">{{ $caseStudy->clinical_history }}</textarea>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-check">
                        <input @if($caseStudy->is_emergency == 1) checked @endif type="checkbox" class="form-check-input" id="emergency" name="emergency" value="1">
                        <label class="form-check-label" for="emergency">Emergency</label>
                    </div>
                    <div class="form-check">
                        <input @if($caseStudy->is_post_operative == 1) checked @endif type="checkbox" class="form-check-input" id="post_operative" name="post_operative" value="1">
                        <label class="form-check-label" for="post_operative">Post Operative</label>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-check">
                        <input @if($caseStudy->is_follow_up == 1) checked @endif type="checkbox" class="form-check-input" id="follow_up" name="follow_up" value="1">
                        <label class="form-check-label" for="follow_up">Follow Up</label>
                    </div>
                    <div class="form-check">
                        <input @if($caseStudy->is_subspecialty == 1) checked @endif type="checkbox" class="form-check-input" id="subspecialty" name="subspecialty" value="1">
                        <label class="form-check-label" for="subspecialty">Subspecialty</label>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-check">
                        <input @if($caseStudy->is_callback == 1) checked @endif type="checkbox" class="form-check-input" id="callback" name="callback" value="1">
                        <label class="form-check-label" for="callback">Callback</label>
                    </div>
                </div>
            </div>
        </div>
        @if($caseStudy->study_status_id <= 2 )
        <div class="row">
            <div class="col-sm-12">
                <button type="button" class="btn btn-warning btn-sm update-existing-case-study float-right" data-index="{{ $caseStudy->id }}">Update Case Details</button>
            </div>
        </div>
        @endif
    </form>
    </div>
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
        
        $('#tabs ul li a[href="#tabs-edit-case"]').addClass('my-complete-class');
        
        $('#assigner_image_view').on('shown.bs.modal', function () {
            $('.save-study').off('click').on('click', function () {
                $(this).html('Saving <i class="fas fa-spinner fa-spin"></i>');
                var studyId = $(this).data('index');
                var layout = $('#layout_' + studyId).val();
                var qcStatus = $('#qc_status_' + studyId).val();

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
                            printSuccessMsg(data.success);
                        } else {
                            printErrorMsg(data.error);
                        }
                    }
                });
            });
        });
        
        $('.add-existing-study').on('click', function() {
            var studyTypeId = $('#add_study_type_id').val();
            var description = $('#add_study_desc').val();
            if (studyTypeId == '') {
                Swal.fire({
                    title: 'Warning!',
                    html: 'Please select a study!',
                    icon: 'warning',
                    confirmButtonText: 'Close',
                    timer: 5000,
                    timerProgressBar: true,
                })
                return false;
            }
            $.ajax({
                url: "{{ route('admin.addMoreStudy') }}",
                type: "POST",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "case_study_id": $('#unique_case_study_id').val(),
                    "study_type_id": studyTypeId,
                    "description": description
                },
                success: function (data) {
                    if(data.status == 'error') {
                        Swal.fire({
                            title: 'Error!',
                            html: data.message,
                            icon: 'error',
                            confirmButtonText: 'Close',
                            timer: 5000,
                            timerProgressBar: true,
                        });
                        return false;
                    }
                    $('.current-study-section').html(data);
                    Swal.fire({
                        title: 'Great!',
                        html: 'Study added successfully!',
                        icon: 'success',
                        confirmButtonText: 'Close',
                        timer: 5000,
                        timerProgressBar: true,
                    });
                }
            });
        });

        $(".current-study-section").on("click", '.update-existing-study', function() {
            var $button = $(this); // capture reference to the button
            var studyId = $button.data("index");
            var $block = $button.closest('.existing-study-block');
            var studyTypeId = $block.find('.existing_study_id').val();
            var description = $block.find('.existing_desc').val();

            Swal.fire({
                title: "Are you sure?",
                text: "You want to update this study!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, Update It!"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('admin.updateExistingStudy') }}",
                        type: "POST",
                        data: {
                            "_token": "{{ csrf_token() }}",
                            "study_id": studyId,
                            "study_type_id": studyTypeId,
                            "description": description,
                            "case_study_id": $('#unique_case_study_id').val(),
                        },
                        success: function(data) {
                            if (data.status === 'success') {
                                Swal.fire({
                                    title: 'Great!',
                                    html: data.message,
                                    icon: 'success',
                                    confirmButtonText: 'Close',
                                    timer: 5000,
                                    timerProgressBar: true,
                                });
                            } else {
                                Swal.fire({
                                    title: 'Error!',
                                    html: data.message,
                                    icon: 'error',
                                    confirmButtonText: 'Close',
                                    timer: 5000,
                                    timerProgressBar: true,
                                });

                                // Reset only the select inside this block
                                var $select = $block.find('.existing_study_id');
                                $select.prop('selectedIndex', $select.find('option[selected]').index());
                            }
                        }
                    });
                }
            });
        });

        $(".current-study-section").on("click", '.remove-existing-study', function() {
            const $button = $(this);
            var studyId = $(this).data("index");
            var studyName = $(this).data("value");
            Swal.fire({
                title: "Are you sure?",
                text: "You want to delete the study " + studyName + "!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, Delete It!"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('admin.deleteExistingStudy') }}",
                        type: "POST",
                        data: {
                            "_token": "{{ csrf_token() }}",
                            "study_id": studyId,
                            "case_study_id": $('#unique_case_study_id').val(),
                        },
                        success: function (data) {
                            if (data.status === 'success') {
                                Swal.fire({
                                    title: 'Great!',
                                    html: data.message,
                                    icon: 'success',
                                    confirmButtonText: 'Close',
                                    timer: 5000,
                                    timerProgressBar: true,
                                }).then((result) => {
                                    if (result.isConfirmed || result.isDismissed) {
                                        $button.closest('.existing-study-block').fadeOut(300);
                                    }
                                });
                            } else {
                                Swal.fire({
                                    title: 'Error!',
                                    html: data.message,
                                    icon: 'error',
                                    confirmButtonText: 'Close',
                                    timer: 5000,
                                    timerProgressBar: true,
                                })
                            }
                        }
                    });
                }
            });
        });

        $('.update-existing-case-study').on('click', function() {
            var caseStudyId = $(this).data('index');
            var form_data = new FormData();
            var other_data = $('#existing_case_study_form').serializeArray();
            form_data.append('case_study_id', caseStudyId);
            $.each(other_data, function (key, input) {
                form_data.append(input.name, input.value);
            });

            $.ajax({
                url: "{{ route('admin.updateCaseStudy') }}",
                type: "POST",
                data: form_data,
                contentType: false,
                processData: false,
                success: function(data) {
                    if (data.status === 'success') {
                        $startDate = $('#start_date').val();
                        $endDate = $('#end_date').val();
                        $doctor_id = $('#doctor_search').val();
                        $centre_id = $('#centre').val();
                        $qc_id = $('#qc_search').val();
                        $status = $('#status_search').val();

                        const params = {
                            sdt: $startDate,
                            edt: $endDate,
                            did: $doctor_id,
                            cid: $centre_id,
                            qid: $qc_id,
                            st: $status,
                        };
                        printSuccessMsg(data.message, params);
                    } else if (data.status === 'error') {
                        Swal.fire({
                            title: 'Error!',
                            html: data.message,
                            icon: 'error',
                            confirmButtonText: 'Close',
                            timer: 5000,
                            timerProgressBar: true,
                        });
                    } else{
                        printErrorMsg(data.error);
                    }
                }
            });
        });

    });
</script>