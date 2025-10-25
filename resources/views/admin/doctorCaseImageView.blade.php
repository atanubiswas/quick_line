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
                <div style="width: 100%;  overflow-x: auto; white-space: nowrap;" class="existing-image-contener-doctor">
                    @php $i = 0; @endphp
                    @foreach($caseStudy->images as $image)
                        @php $ext = strtolower(pathinfo($image->image, PATHINFO_EXTENSION)); @endphp
                        @if($ext === 'pdf')
                            @php
                                $previewTextWidth = 90;
                                $avgCharWidth = 6.5;
                                $maxChars = max(6, (int) floor($previewTextWidth / $avgCharWidth));
                            @endphp
                            <div class="m-2 position-relative d-inline-block">
                                <a href="{{ asset('storage/' . $image->image) }}" data-pdf="{{ asset('storage/' . $image->image) }}" class="pdf-preview-link-doctor" style="text-decoration:none;color:inherit;">
                                    <div class="pdf-preview d-flex align-items-center justify-content-center bg-light border" style="width:160px;height:160px;cursor: pointer;padding:5px;">
                                        <div class="text-center">
                                            <i class="fas fa-file-pdf fa-2x text-danger"></i>
                                            <div style="font-size:11px;word-break:break-word;max-width:90px;">{{ \Illuminate\Support\Str::limit(basename($image->image), $maxChars) }}</div>
                                        </div>
                                    </div>
                                </a>
                                @if($caseStudy->study_status_id <=2)
                                    <button type="button" class="existing-img-close-btn btn btn-danger btn-sm" data-index="{{ $i }}" style="position: absolute; top: 5px; right: 5px; border-radius: 30px; height: 20px; width: 20px; display: flex; justify-content: center; align-items: center; padding: 0; font-size: 14px;"> × </button>
                                @endif
                            </div>
                        @else
                            <img src="{{ asset('storage/' . $image->image) }}" data-file-index="{{ $i }}" id="existing_image_doctor_{{ $i }}" height="160px" style="padding:5px; cursor:pointer" class="image-thumb-doctor" />
                        @endif
                        @php $i++; @endphp
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
                        @php
                            $firstFile = $caseStudy->images[0]->image ?? null;
                            $firstExt = $firstFile ? strtolower(pathinfo($firstFile, PATHINFO_EXTENSION)) : null;
                        @endphp
                        @if($firstExt === 'pdf')
                            <iframe id="doctor-pdf-iframe" src="{{ asset('storage/' . $firstFile) }}" style="width:100%;height:600px;border:none;" allow="fullscreen"></iframe>
                            <img id="cropImage-doctor" src="" style="display:none;max-width: 100%; width: 100%; padding:5px" />
                            <div class="crop-toolbar" style="display:none;">
                        @else
                            <img src="{{ asset('storage/' . $caseStudy->images[0]->image) }}" id="cropImage-doctor" style="max-width: 100%; width: 100%; padding:5px" />
                            <div class="crop-toolbar">
                        @endif
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
                                @if(($authUser->roles[0]->pivot->role_id == 2 && in_array($caseStudy->study_status_id, [3])) || ($authUser->roles[0]->pivot->role_id == 4 && in_array($caseStudy->study_status_id, [2, 4])))
                                <div class="form-group">
                                    <button type="button" class="btn btn-success float-right save-study" id="save_btn_{{ $study->id }}" data-index="{{ $study->id }}" data-study-status-id="{{ $caseStudy->study_status_id }}">Save</button>
                                </div>
                                @endif
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
    $(function() {
        // Fix aria-hidden focus error when closing modal
        $('#doc_image_view').on('hide.bs.modal', function () {
            var modal = this;
            var active = document.activeElement;
            if (active && modal.contains(active)) {
                active.blur();
                console.log('[Modal Blur] Removed focus from element inside modal before closing.');
            }
        });
        // Doctor view: open PDF in iframe when clicking PDF preview
        $('.existing-image-contener-doctor').on('click', 'a.pdf-preview-link-doctor', function (e) {
            if (e.ctrlKey || e.metaKey) {
                return true;
            }
            e.preventDefault();
            var url = $(this).data('pdf');
            var $cardBody = $('.card-body.box-profile');

            try {
                if (typeof cropper !== 'undefined' && cropper) {
                    cropper.destroy();
                    cropper = null;
                }
            } catch (err) {}
            $('.cropper-container').remove();
            $('#cropImage-doctor').hide();
            $('.crop-toolbar').hide();

            $('#doctor-pdf-iframe').remove();
            var $iframe = $('<iframe>', { id: 'doctor-pdf-iframe', src: url, allow: 'fullscreen' }).css({ width: '100%', height: '600px', border: 'none' });
            $cardBody.prepend($iframe);
            if ($cardBody.length) {
                $('html, body').animate({ scrollTop: $cardBody.offset().top - 50 }, 300);
            }
        });

        // Doctor view: clicking an image thumbnail should remove iframe and show image
        $(document).on('click', '.image-thumb-doctor', function () {
            $('#doctor-pdf-iframe').remove();
            let imgSrc = $(this).attr('src');
            $('#cropImage-doctor').attr('src', imgSrc).show();
            $('.crop-toolbar').show();

            if (cropper) {
                cropper.destroy();
                cropper = null;
            }

            // initialize cropper for doctor image
            let image = document.getElementById('cropImage-doctor');
            cropper = new Cropper(image, {
                aspectRatio: NaN,
                viewMode: 2,
                autoCropArea: 1,
                responsive: true,
                restore: false,
                scalable: true,
                zoomable: true,
                rotatable: true,
                movable: true,
                autoCrop: false
            });
            setTimeout(() => { if (cropper && typeof cropper.resize === 'function') cropper.resize(); }, 300);
        });
        var caseId = $('#unique_case_study_id').val();
        // Initialize tabs FIRST
        $("#tabs").tabs({
            activate: function(event, ui) {
                // When a tab is activated, initialize Summernote for any .layout-doctor in the panel if not already initialized
                $(ui.newPanel).find('.layout-doctor').each(function() {
                    var $textarea = $(this);
                    if (!$textarea.hasClass('summernote-initialized')) {
                        var studyId = $textarea.attr('id').split('_')[1];
                        var status = $textarea.closest('form').find('.doctor-layout-selector').length ? $textarea.closest('form').find('.doctor-layout-selector').data('status') : null;
                        if (!status) {
                            status = $textarea.data('status') || null;
                        }
                        $textarea.summernote({
                            height: 300,
                            fontNames: [
                                'Arial', 'Arial Black', 'Comic Sans MS', 'Courier New', 'Merriweather',
                                'Times New Roman', 'Georgia', 'Tahoma', 'Verdana', 'Trebuchet MS',
                                'Impact', 'Lucida Console', 'Palatino Linotype', 'Garamond', 'Bookman',
                                'Candara', 'Calibri', 'Optima', 'Segoe UI', 'Franklin Gothic Medium',
                                'Gill Sans', 'Geneva', 'Futura', 'Rockwell', 'Monaco', 'Brush Script MT'
                            ],
                            fontNamesIgnoreCheck: ['Merriweather', 'Brush Script MT', 'Futura', 'Rockwell'],
                            toolbar: [
                                ['style', ['bold', 'italic', 'underline', 'clear']],
                                ['font', ['strikethrough', 'superscript', 'subscript']],
                                ['fontname', ['fontname']],
                                ['fontsize', ['fontsize']],
                                ['color', ['color']],
                                ['para', ['ul', 'ol', 'paragraph']],
                                ['height', ['height']]
                            ],
                            callbacks: {
                                onInit: function() {
                                    var layoutKey = 'draft_layout_' + caseId + '_' + studyId;
                                    var statusVal = $textarea.closest('form').find('.doctor-layout-selector').length ? $textarea.closest('form').find('.doctor-layout-selector').data('status') : null;
                                    if (!statusVal) {
                                        statusVal = $textarea.data('status') || null;
                                    }
                                    statusVal = statusVal || '{{ $study->status ?? "" }}';
                                    console.log('[Draft Load] studyId:', studyId, 'status:', statusVal, 'layoutKey:', layoutKey);
                                    if (statusVal != '1') {
                                        var draft = localStorage.getItem(layoutKey);
                                        console.log('[Draft Load] Found draft:', draft);
                                        if (draft) {
                                            $textarea.summernote('code', draft);
                                        }
                                    }
                                },
                                onChange: function(contents, $editable) {
                                    var layoutKey = 'draft_layout_' + caseId + '_' + studyId;
                                    console.log('[Draft Save - onChange] studyId:', studyId, 'layoutKey:', layoutKey, 'value:', contents);
                                    localStorage.setItem(layoutKey, contents);
                                }
                            }
                        });
                        $textarea.addClass('summernote-initialized');
                    }
                });
            }
        });
        // Initialize Summernote for visible tab panels on page load
        $('#tabs > div:visible').find('.layout-doctor').each(function() {
            var $textarea = $(this);
            if (!$textarea.hasClass('summernote-initialized')) {
                var studyId = $textarea.attr('id').split('_')[1];
                var status = $textarea.closest('form').find('.doctor-layout-selector').length ? $textarea.closest('form').find('.doctor-layout-selector').data('status') : null;
                if (!status) {
                    status = $textarea.data('status') || null;
                }
                $textarea.summernote({
                    height: 300,
                    fontNames: [
                        'Arial', 'Arial Black', 'Comic Sans MS', 'Courier New', 'Merriweather',
                        'Times New Roman', 'Georgia', 'Tahoma', 'Verdana', 'Trebuchet MS',
                        'Impact', 'Lucida Console', 'Palatino Linotype', 'Garamond', 'Bookman',
                        'Candara', 'Calibri', 'Optima', 'Segoe UI', 'Franklin Gothic Medium',
                        'Gill Sans', 'Geneva', 'Futura', 'Rockwell', 'Monaco', 'Brush Script MT'
                    ],
                    fontNamesIgnoreCheck: ['Merriweather', 'Brush Script MT', 'Futura', 'Rockwell'],
                    toolbar: [
                        ['style', ['bold', 'italic', 'underline', 'clear']],
                        ['font', ['strikethrough', 'superscript', 'subscript']],
                        ['fontname', ['fontname']],
                        ['fontsize', ['fontsize']],
                        ['color', ['color']],
                        ['para', ['ul', 'ol', 'paragraph']],
                        ['height', ['height']]
                    ],
                    callbacks: {
                        onInit: function() {
                            var layoutKey = 'draft_layout_' + caseId + '_' + studyId;
                            var statusVal = $textarea.closest('form').find('.doctor-layout-selector').length ? $textarea.closest('form').find('.doctor-layout-selector').data('status') : null;
                            if (!statusVal) {
                                statusVal = $textarea.data('status') || null;
                            }
                            statusVal = statusVal || '{{ $study->status ?? "" }}';
                            console.log('[Draft Load] studyId:', studyId, 'status:', statusVal, 'layoutKey:', layoutKey);
                            if (statusVal != '1') {
                                var draft = localStorage.getItem(layoutKey);
                                console.log('[Draft Load] Found draft:', draft);
                                if (draft) {
                                    $textarea.summernote('code', draft);
                                }
                            }
                        },
                        onChange: function(contents, $editable) {
                            var layoutKey = 'draft_layout_' + caseId + '_' + studyId;
                            console.log('[Draft Save - onChange] studyId:', studyId, 'layoutKey:', layoutKey, 'value:', contents);
                            localStorage.setItem(layoutKey, contents);
                        }
                    }
                });
                $textarea.addClass('summernote-initialized');
            }
        });

        // Draft save/load logic
        // ...existing code...

        // Save draft on change
        // Removed: draft save on input/change, now handled by Summernote onChange
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
            var caseId = $('#unique_case_study_id').val();
            var layoutKey = 'draft_layout_' + caseId + '_' + studyId;
            // Save current draft before changing layout
            var $textarea = $('#layout_' + studyId);
            var value = $textarea.hasClass('summernote') ? $textarea.summernote('code') : $textarea.val();
            console.log('[Draft Save Before Layout Change] studyId:', studyId, 'layoutKey:', layoutKey, 'value:', value);
            localStorage.setItem(layoutKey, value);
            // Now load new layout
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
            // Reload draft for each unsaved study when modal is opened
            var caseId = $('#unique_case_study_id').val();
            @foreach($caseStudy->study as $study)
                var studyId = '{{ $study->id }}';
                var status = '{{ $study->status }}';
                var layoutKey = 'draft_layout_' + caseId + '_' + studyId;
                console.log('[Modal Draft Load] studyId:', studyId, 'status:', status, 'layoutKey:', layoutKey);
                if (status != '1') {
                    var draft = localStorage.getItem(layoutKey);
                    console.log('[Modal Draft Load] Found draft:', draft);
                    if (draft) {
                        $('#layout_' + studyId).summernote('code', draft);
                    }
                }
            @endforeach

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
                                // Remove draft after successful save
                                var layoutKey = 'draft_layout_' + caseId + '_' + studyId;
                                localStorage.removeItem(layoutKey);
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
</script>