@extends('layouts.admin_layout')
@section('title', "View Case Studies")
@section('extra_css')
    <style type="text/css">
        label em {
            color: #FF0000;
        }
        .modal-dialog {
            max-width: 80%;
        }

        /* Crop image constraints */
        #cropImage {
            max-width: 100% !important;
            max-height: 70vh !important;
            display: block;
            margin: 0 auto;
        }

        /* Position and style the floating toolbar */
        .crop-toolbar {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-wrap: wrap;
            gap: 0.8rem;
            background-color: rgba(60, 60, 60, 0.8);
            border-radius: 10px;
            padding: 0.5rem 1rem;
            margin-top: 10px; /* Push it below the image */
            width: 100%;
        }

        .toolbar-btn {
            background: none;
            border: none;
            color: #fff;
            font-size: 1rem;
            cursor: pointer;
            padding: 6px;
        }

        .toolbar-btn:hover {
            color: #ffd700;
        }

        /* Fix rotation wheel inside toolbar */
        .rotation-container {
            width: 50px;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0; /* Prevents it from resizing */
        }

        /* Make rotation wheel match button size */
        #rotation-wheel {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: radial-gradient(circle, #444 40%, #222 100%);
            position: relative;
            display: flex;
            justify-content: center;
            align-items: center;
            box-shadow: 0 0 8px rgba(255, 255, 255, 0.3);
            border: 2px solid #666;
        }

        /* Main Indicator Line (Big Line) */
        .main-line {
            position: absolute;
            width: 3px;
            height: 20px;
            background: red;
            top: 5px;
            left: 50%;
            transform: translateX(-50%);
            border-radius: 2px;
        }

        /* Small Lines around the knob */
        .small-lines {
            position: absolute;
            width: 100%;
            height: 100%;
            pointer-events: none;
        }

        .small-lines::before,
        .small-lines::after {
            content: "";
            position: absolute;
            width: 2px;
            height: 8px;
            background: white;
            left: 50%;
            transform: translateX(-50%);
        }

        /* Top Small Line */
        .small-lines::before {
            top: 10%;
        }

        /* Bottom Small Line */
        .small-lines::after {
            bottom: 10%;
        }

        .cropper-point {
            width: 16px !important; /* Increase width */
            height: 16px !important; /* Increase height */
            background: white !important; /* Make them visible */
            border: 2px solid #000 !important; /* Add contrast */
            border-radius: 50% !important; /* Circular handles */
            opacity: 1 !important; /* Ensure visibility */
        }

        .rotation-input {
            width: 60px;
            height: 40px;
            text-align: center;
            font-size: 1rem;
            border: none;
            border-radius: 5px;
            outline: none;
        }

        /* Adjust for mobile screens */
        @media (max-width: 768px) {
            .crop-toolbar {
                flex-wrap: wrap;
                max-width: 90%;
                padding: 0.3rem 0.8rem;
                gap: 0.5rem;
            }
            
            .toolbar-btn {
                font-size: 0.9rem;
                padding: 5px;
            }
        }

        @media (max-width: 480px) {
            .cropper-point {
                width: 26px !important;
                height: 26px !important;
            }
        }

        .cropper-container{
            width:100% !important;
        }
        .upload-container {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        /* Style for Upload (Browse) Button */
        .upload-btn, .camera-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 8px 12px;
            background-color: #007bff;
            color: white;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
        }
        .upload-btn i, .camera-btn i {
            margin-right: 5px;
        }

        /* Style for Camera Button */
        .camera-btn {
            background-color: #28a745;
        }

        #image-container {
            position: relative;
            display: inline-block;
        }
        .resizable-rect {
            position: absolute;
            border: 2px solid rgba(46, 46, 46, 1);
            background: rgba(46, 46, 46, 1);
        }

        .ui-resizable-handle {
            width: 10px;
            height: 10px;
            background: white;
            border: 1px solid black;
            position: absolute;
        }
        .ui-resizable-n { top: -5px; left: 50%; transform: translateX(-50%); cursor: n-resize; }
        .ui-resizable-s { bottom: -5px; left: 50%; transform: translateX(-50%); cursor: s-resize; }
        .ui-resizable-e { right: -5px; top: 50%; transform: translateY(-50%); cursor: e-resize; }
        .ui-resizable-w { left: -5px; top: 50%; transform: translateY(-50%); cursor: w-resize; }
        .ui-resizable-ne { top: -5px; right: -5px; cursor: ne-resize; }
        .ui-resizable-nw { top: -5px; left: -5px; cursor: nw-resize; }
        .ui-resizable-se { bottom: -5px; right: -5px; cursor: se-resize; }
        .ui-resizable-sw { bottom: -5px; left: -5px; cursor: sw-resize; }

        .study-section {
            border: 1px solid #ccc;
            padding: 15px;
            margin-bottom: 10px;
            border-radius: 5px;
            background-color: #f9f9f9;
        }

        .btn {
            margin-left: 5px;
        }

        .d-none {
            display: none;
        }

        .upload-container {
            display: flex;
            gap: 10px;
            margin-top: 10px;
        }
    </style>

    <!-- DataTables -->
    <link rel="stylesheet" href="{{asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{asset('plugins/select2/css/select2.min.css')}}">
    <link rel="stylesheet" href="{{asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">

    <!-- CROPPER CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.css">
@endsection
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>{{$pageName}}</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">{{$pageName}}</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card card-purple">
                            <div class="card-header">
                                <h3 class="card-title" style="color: #fff;">View {{$pageName}} Data</h3>
                                <button type="button" id="add_case_study_btn" class="btn bg-gradient-success float-right btn-sm" data-toggle="modal" data-target="#add-case-study-modal">Add {{$pageName}}</button>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="study_table" class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>Patient Name</th>
                                            <th>Age & Sex</th>
                                            <th>Modality</th>
                                            <th>Study & Description</th>
                                            <th>History</th>
                                            <th>Doctor</th>
                                            <th>Images</th>
                                            <th>Centre</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($CaseStudies as $caseStudy)
                                            <tr class="case-study-row">
                                                <td>{{$caseStudy->case_study_id}}</td>
                                                <td>{{$caseStudy->case_study_id}}</td>
                                                <td>{{$caseStudy->case_study_id}}</td>
                                                <td>{{$caseStudy->case_study_id}}</td>
                                                <td>{{$caseStudy->case_study_id}}</td>
                                                <td>{{$caseStudy->case_study_id}}</td>
                                                <td>{{$caseStudy->case_study_id}}</td>
                                                <td>{{$caseStudy->case_study_id}}</td>
                                                <td>{{$caseStudy->case_study_id}}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->

                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
            <div class="modal fade" id="add-case-study-modal">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Add New {{ $pageName }}</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body" style="overflow: scroll;">
                            <form method="post" id="case_study_form" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-9">
                                        <div class="form-group">
                                            <label for="centre">Select Centre <em>*</em></label>
                                            <select name="centre_id" id="centre_id" class="form-control" style="width: 100%;">
                                                <option value="">Select Centre</option>
                                                @foreach($Labrotories as $Labrotory)
                                                    <option value="{{$Labrotory->id}}">{{$Labrotory->lab_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="modality">Select Modality <em>*</em></label>
                                            <select name="modality" id="modality" class="form-control" style="width: 100%;">
                                                <option value="">Select Modality</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="existing_patient" name="existing_patient" value="1">
                                                <label class="form-check-label" for="existing_patient">Existing Patient?</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" id="patient_id_container" style="display: none;">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="patient_id">Patient ID <em>*</em></label>
                                            <input type="text" name="patient_id" id="patient_id" class="form-control" placeholder="Enter Patient ID">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-7">
                                        <div class="form-group">
                                            <label for="patient_name">Patient Name <em>*</em></label>
                                            <input type="text" name="patient_name" id="patient_name" class="form-control"
                                                placeholder="Enter Patient Name">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="age">Age <em>*</em></label>
                                            <input type="text" name="age" id="age" class="form-control" placeholder="Enter Age">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="gender">Gender <em>*</em></label>
                                            <select name="gender" id="gender" class="form-control" style="width: 100%;">
                                                <option value="">Select Gender</option>
                                                <option value="male">Male</option>
                                                <option value="female">Female</option>
                                                <option value="other">Other</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div id="study-sections">
                                    <div class="study-section">
                                        <div class="row">
                                            <div class="col-sm-5">
                                                <div class="form-group">
                                                    <label for="study">Study <em>*</em></label>
                                                    <select name="study_id[]" class="form-control study_id"></select>
                                                </div>
                                            </div>
                                            <div class="col-sm-5">
                                                <div class="form-group">
                                                    <label for="description">Description</label>
                                                    <textarea name="description[]" class="form-control description"
                                                        placeholder="Enter Description"></textarea>
                                                </div>
                                            </div>

                                            <!-- Buttons beside fields -->
                                            <div class="col-sm-2 d-flex align-items-end">
                                                <button type="button" class="btn btn-success add-study"><i class="fas fa-plus"></i></button>
                                                <button type="button" class="btn btn-danger remove-study d-none"><i class="fas fa-minus"></i></button>
                                            </div>
                                        </div>

                                        <!-- Upload Section (Now included in every study section) -->
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <div class="upload-container">
                                                        <!-- Browse Files Button -->
                                                        <label class="upload-btn">
                                                            <i class="fas fa-folder-open"></i> Browse
                                                            <input type="file" class="uploadImages" multiple="multiple" accept="image/*" hidden>
                                                        </label>

                                                        <!-- Camera Button -->
                                                        <label class="camera-btn">
                                                            <i class="fas fa-camera"></i>
                                                            <input type="file" class="cameraUpload" accept="image/*" capture="environment" hidden>
                                                        </label>
                                                    </div>
                                                    <div class="previewImages d-flex flex-wrap mt-3"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="history">Clinical History <em>*</em></label>
                                            <textarea name="clinical_history" id="clinical_history" class="form-control"
                                                placeholder="Enter Clinical History"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="emergency" name="emergency" value="1">
                                                <label class="form-check-label" for="emergency">Emergency</label>
                                            </div>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="post_operative" name="post_operative" value="1">
                                                <label class="form-check-label" for="post_operative">Post Operative</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="follow_up" name="follow_up" value="1">
                                                <label class="form-check-label" for="follow_up">Follow Up</label>
                                            </div>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="subspecialty" name="subspecialty" value="1">
                                                <label class="form-check-label" for="subspecialty">Subspecialty</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="callback" name="callback" value="1">
                                                <label class="form-check-label" for="callback">Callback</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-success" id="save_study">Save Study</button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!-- /.modal -->

            <div class="modal fade" id="cropModal" tabindex="-1" aria-hidden="true" style="overflow: scroll;">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Edit Image</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body text-center position-relative" id="image-container">
                            <img id="cropImage" style="max-width: 100%; width: 100%;">
                            <div class="crop-toolbar">
                                <div id="rotation-wheel">
                                    <!-- Main Line -->
                                    <div class="main-line"></div>
                                    
                                    <!-- Small Lines -->
                                    <div class="small-lines"></div>
                                </div>
                                
                                <!-- Manual Rotation Input -->
                                <input type="number" id="rotation-angle" class="rotation-input" min="0" max="360" value="0">

                                <button class="toolbar-btn" id="flipHorizontal" title="Flip Horizontal">
                                    <i class="fas fa-arrows-alt-h"></i>
                                </button>
                                <button class="toolbar-btn" id="flipVertical" title="Flip Vertical">
                                    <i class="fas fa-arrows-alt-v"></i>
                                </button>
                                <button class="toolbar-btn" id="crop" title="Crop">
                                    <i class="fas fa-crop"></i>
                                </button>
                                <!-- <button class="toolbar-btn" id="add-rectangle" title="Draw Rectangle">
                                <i class="fas fa-square"></i>
                                </button> -->
                                <button class="toolbar-btn" id="moveLeft" title="Move Left">
                                    <i class="fas fa-arrow-left"></i>
                                </button>
                                <button class="toolbar-btn" id="moveRight" title="Move Right">
                                    <i class="fas fa-arrow-right"></i>
                                </button>
                                <button class="toolbar-btn" id="moveUp" title="Move Up">
                                    <i class="fas fa-arrow-up"></i>
                                </button>
                                <button class="toolbar-btn" id="moveDown" title="Move Down">
                                    <i class="fas fa-arrow-down"></i>
                                </button>
                                <button class="toolbar-btn" id="zoomOut" title="Zoom Out">
                                    <i class="fas fa-search-minus"></i>
                                </button>
                                <button class="toolbar-btn" id="zoomIn" title="Zoom In">
                                    <i class="fas fa-search-plus"></i>
                                </button>
                            </div>
                        </div>
                        <canvas id="canvas" style="display:none;"></canvas>
                        <div class="modal-footer">
                            <button class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            <button class="btn btn-success" id="cropSave">Save</button>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- /.content -->
    </div>
@endsection

@section("extra_js")
    <!-- DataTables  & Plugins -->
    <script src="{{asset('plugins/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
    <script src="{{asset('plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
    <script src="{{asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>
    <script src="{{asset('plugins/datatables-buttons/js/dataTables.buttons.min.js')}}"></script>
    <script src="{{asset('plugins/datatables-buttons/js/buttons.bootstrap4.min.js')}}"></script>
    <script src="{{asset('plugins/select2/js/select2.full.min.js')}}"></script>

    <!-- CROPPER JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.js"></script>
    
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script>
        $(function () {
            let allFiles = [];
            let cropperInstances = {};
            let cropper;
            let isCropping = false;

            let rectCount = 0;
            let currentFile;
            var scaleX = 1;
            var scaleY = 1;

            let isDragging = false;
            let startAngle = 0;
            let currentAngle = 0;

            $("#study-sections").on("click", ".add-study", function () {
                let newSection = $(".study-section").first().clone(); // Clone the first section

                // Clear values in the cloned section
                newSection.find("select").val(""); // Reset dropdown
                newSection.find("textarea").val(""); // Reset textareas
                newSection.find("input[type='file']").val(""); // Reset file inputs
                newSection.find(".previewImages").html(""); // Clear image preview

                // Show the minus button in the new section
                newSection.find(".remove-study").removeClass("d-none");

                // Append new section with animation
                newSection.hide().appendTo("#study-sections").fadeIn(300);
            });

            // Function to remove a study section
            $("#study-sections").on("click", ".remove-study", function () {
                if ($(".study-section").length > 1) { // Prevent removing the last section
                    $(this).closest(".study-section").fadeOut(300, function () {
                        $(this).remove();
                    });
                } else {
                    alert("At least one study section is required!");
                }
            });

            $("#existing_patient").change(function() {
                if ($(this).is(":checked")) {
                    $("#patient_id").val("QL-PT-");
                    $("#patient_id_container").show(500);
                    $("#patient_id").focus().trigger("click");
                } else {
                    $("#patient_id").val("");
                    $("#patient_id_container").hide(500);
                }
            });

            $('#patient_id').on('focus click', function () {
                let length = $(this).val().length;
                $(this)[0].setSelectionRange(length, length);
            });

            $("#patient_id").on("blur", function() {
                let patientId = $(this).val();
                if (patientId != "") {
                    $.ajax({
                        url: "{{ url('admin/get-patient-details') }}",
                        type: "POST",
                        data: {
                            "_token": "{{ csrf_token() }}",
                            "patient_id": patientId
                        },
                        success: function(response) {
                            if (response.status == "success") {
                                $("#patient_name").val(response.patient.name);
                                $("#age").val(response.patient.age);
                                $("#gender").val(response.patient.gender);
                                $("#clinical_history").val(response.patient.clinical_history);
                            }
                        }
                    });
                }
            });

            $("#add_case_study_btn").click(function () {
                $("#case_study_form")[0].reset();
                $("#previewImages").html("");
            });

            $("#uploadImages, #cameraUpload").on("change", function (event) {
                let files = event.target.files;

                $.each(files, function (index, file) {
                    let fileIndex = allFiles.length; // Unique index for each file
                    allFiles.push(file); // Store file in array

                    let reader = new FileReader();
                    reader.onload = function (e) {
                        let imgId = "img-" + fileIndex;
                        
                        // Make sure the image preview is inside a valid parent section
                        let previewHTML = `
                            <div class="image-upload-section m-2 position-relative d-inline-block" id="preview-${fileIndex}">
                                <img src="${e.target.result}" id="${imgId}" class="img-thumbnail preview-img" 
                                    width="100" height="100" style="cursor: pointer;" data-file-index="${fileIndex}">
                                <button type="button" class="close-btn btn btn-danger btn-sm" data-index="${fileIndex}" 
                                    style="position: absolute; top: 5px; right: 5px;">×</button>
                            </div>
                        `;

                        $("#previewImages").append(previewHTML);
                    };
                    reader.readAsDataURL(file);
                });

                $(this).val(""); // Reset input field to allow re-selection
            });

            // Handle image removal when clicking the close button
            $("#study-sections").on("click", ".close-btn", function () {
                let fileIndex = $(this).data("index");
                $("#preview-" + fileIndex).remove(); // Remove from UI
            });

            // $("#previewImages").on("click", ".close-btn", function () {
            //     let index = $(this).data("index");
            //     $("#preview-" + index).remove();
            //     allFiles[index] = null; // Mark file as removed
            // });

            $("#save_study").on("click", function (event) {
                $(this).html('Saving <i class="fas fa-spinner fa-spin"></i>');
                $(".form-control").removeClass("is-invalid");
                $(".error").remove();
                if($("#patient_id").val() === "QL-PT-"){
                    $("#patient_id").val("");
                }
                var form_data = new FormData();
                var other_data = $('#case_study_form').serializeArray();
                $.each(other_data, function (key, input) {
                    form_data.append(input.name, input.value);
                });
                allFiles.forEach((file, index) => {
                    console.log(file);
                    console.log(index);
                    if (file) {
                        form_data.append("images[]", file);
                    }
                });
                
                $.ajax({
                    url: '{{url("admin/insert-case-study")}}',
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: form_data,
                    type: 'post',
                    success: function (data) {
                        $('#save_study').html('Save');
                        if ($.isEmptyObject(data.error)) {
                            printSuccessMsg(data.success);
                            $('#case_study_form').trigger("reset");
                        } else {
                            printErrorMsg(data.error);
                        }
                    },
                    error: function (data) {
                        $('#save_study').html('Save');
                    }
                });
            });

        // Open Cropper Modal when an image is clicked
        $(document).on("click", ".preview-img", function () {
            let imgSrc = $(this).attr("src");
            let fileIndex = $(this).data("file-index"); // Store file index
            let parentSection = $(this).closest(".image-upload-section"); // Get the parent section

            console.log("Current File Index:", fileIndex);
            console.log("Parent Section:", parentSection);

            if (fileIndex === undefined || !parentSection.length) {
                console.error("File index or parent section not found!");
                return;
            }

            $("#cropImage").attr("src", imgSrc);

            // Store data in the modal before opening
            $("#cropModal").data("file-index", fileIndex);
            $("#cropModal").data("parent-section", parentSection);

            $("#cropModal").modal("show");

            $("#cropModal").on("shown.bs.modal", function () {
                if (cropper) {
                    cropper.destroy();
                }

                let image = document.getElementById("cropImage");
                cropper = new Cropper(image, {
                    aspectRatio: NaN, // Free cropping
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
            });
        });

        $(document).on("click", "#flipHorizontal", function () {
            scaleX = scaleX === 1 ? -1 : 1; // Toggle between 1 and -1
            cropper.scaleX(scaleX);
        });

        $(document).on("click", "#flipVertical", function () {
            scaleY = scaleY === 1 ? -1 : 1; // Toggle between 1 and -1
            cropper.scaleY(scaleY);
        });

        $(document).on("click", "#crop", function () {
            if (cropper) {
                if (isCropping) {
                    cropper.clear(); // Hide the crop box
                } else {
                    cropper.crop();  // Show the crop box
                }
                isCropping = !isCropping;
            }
        });

        $(document).on("click", "#zoomIn", function () {
            cropper.zoom(0.1);
        });

        $(document).on("click", "#zoomOut", function () {
            cropper.zoom(-0.1);
        });

        $(document).on("click", "#moveLeft", function () {
            cropper.move(-10, 0);
        });

        $(document).on("click", "#moveRight", function () {
            cropper.move(10, 0);
        });

        $(document).on("click", "#moveUp", function () {
            cropper.move(0, -10);
        });

        $(document).on("click", "#moveDown", function () {
            cropper.move(0, 10);
        });

        $("#add-rectangle").click(function () {
            let rect = $('<div class="resizable-rect" tabindex="0"></div>');
            rect.css({ width: "100px", height: "50px", top: "250px", left: "150px" });

            $("#image-container").append(rect);

            // Make it draggable and resizable with handles
            rect.draggable({ containment: "#image-container" }).resizable({
                handles: "n, e, s, w, ne, nw, se, sw"
            });

            // Show resize handles when clicked
            rect.on("focus", function () {
                $(this).find(".ui-resizable-handle").show();
            });

            // Hide resize handles when clicked outside
            rect.on("blur", function () {
                $(this).find(".ui-resizable-handle").hide();
            });

            // Ensure focus on click (so clicking it shows handles)
            rect.click(function () {
                $(this).focus();
            });

            $(document).keydown(function (event) {
                if (event.key === "Delete" || event.keyCode === 46) {
                    $(".resizable-rect:focus").remove();
                }
            });
        });
        // Crop & Save
        $("#cropSave").click(function () {
            if (!cropper) return;

            let canvas = cropper.getCroppedCanvas();
            let croppedImage = canvas.toDataURL("image/png"); // Convert to Base64

            console.log("Cropped Image:", croppedImage);

            // Retrieve stored information from the modal
            let fileIndex = $("#cropModal").data("file-index");
            let parentSection = $("#cropModal").data("parent-section");

            if (fileIndex === undefined || !parentSection.length) {
                console.error("File index or parent section is missing!");
                return;
            }

            // Find the correct preview image
            let imgSelector = parentSection.find(`img[data-file-index="${fileIndex}"]`);
            if (!imgSelector.length) {
                console.error("Image selector not found!");
                return;
            }

            // Replace the preview image source
            imgSelector.attr("src", croppedImage);
            $("#cropModal").modal("hide");

            // Get the original file
            let fileInput = parentSection.find(".uploadImages");
            let filesArray = fileInput.prop("files"); 

            if (!filesArray || filesArray.length === 0) {
                console.error("No files found in input!");
                return;
            }

            // Convert Base64 to Blob
            let croppedBlob = dataURLtoBlob(croppedImage);
            
            // Create a new File object
            let originalFile = filesArray[fileIndex];
            let croppedFile = new File([croppedBlob], originalFile.name, { type: originalFile.type });

            // Create a new FileList with the updated file
            let dataTransfer = new DataTransfer();
            for (let i = 0; i < filesArray.length; i++) {
                dataTransfer.items.add(i === fileIndex ? croppedFile : filesArray[i]);
            }

            // Update input file list
            fileInput.prop("files", dataTransfer.files);

            console.log("Cropped file updated in input field.");
        });

        // Convert Base64 to Blob
        function dataURLtoBlob(dataURL) {
            let arr = dataURL.split(',');
            let mime = arr[0].match(/:(.*?);/)[1];
            let bstr = atob(arr[1]);
            let n = bstr.length;
            let u8arr = new Uint8Array(n);

            while (n--) {
                u8arr[n] = bstr.charCodeAt(n);
            }

            return new Blob([u8arr], { type: mime });
        }

        $("#cropModal").on("hidden.bs.modal", function () {
            isCropping = !isCropping;
            if ($('.modal.show').length) {  // Check if any other modal is still open
                $('body').addClass('modal-open');
            }
        });

        $('#study_table').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
            "lengthMenu": [[10, 25, 50, 100, 500, -1], [10, 25, 50, 100, 500, "All"]]
        });

        $('#centre_id').select2({
            dropdownParent: $('#add-case-study-modal'),
            theme: 'bootstrap4',
            placeholder: '-- Select Centre --',
            tags: true,
            allowClear: true
        });

        $('#study_id').select2({
            theme: 'bootstrap4',
            placeholder: '-- Select Study --',
            selectionCssClass: 'bg-purple'
        });
        
        $('#modality').select2({
            theme: 'bootstrap4',
            selectionCssClass: 'bg-purple'
        });

        $('#centre_id').on('change', function () {
            var centre = $(this).val();
            if (centre != '') {
                $.ajax({
                    url: "{{ route('get-modality') }}",
                    type: "POST",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "lab_id": centre
                    },
                    success: function (response) {
                        $('#modality').html(response).trigger('change');
                    }
                });
            }
        });

        $("#modality").on("change", function (e) {
            var modality =  $(this).val();
            if (modality != '') {
                $.ajax({
                    url: "{{ route('get-study-type') }}",
                    type: "POST",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "modality_id": modality
                    },
                    success: function (response) {
                        $('#study_id').html(response);
                    }
                });
            }
        });
    
        function getAngle(event, element) {
            let touch = event.touches ? event.touches[0] : event;
            let rect = element.getBoundingClientRect();
            let centerX = rect.left + rect.width / 2;
            let centerY = rect.top + rect.height / 2;
            let moveX = touch.clientX - centerX;
            let moveY = touch.clientY - centerY;
            return Math.atan2(moveY, moveX) * (180 / Math.PI);
        }

        function startRotation(event) {
            isDragging = true;
            startAngle = getAngle(event, $("#rotation-wheel")[0]);
            event.preventDefault(); // Prevent scrolling on mobile
        }

        function normalizeAngle(angle) {
            return (angle + 360) % 360; // Ensures angle stays between 0-360
        }

        function rotate(event) {
            if (!isDragging) return;
            let newAngle = getAngle(event, $("#rotation-wheel")[0]);
            let rotation = newAngle - startAngle + currentAngle;

            // Normalize the angle to always stay between 0-360
            let fixedAngle = normalizeAngle(rotation);

            // Rotate image using Cropper.js
            cropper.rotateTo(fixedAngle);

            // Rotate the knob
            $("#rotation-wheel").css("transform", `rotate(${fixedAngle}deg)`);

            // Update textbox with fixed value
            $("#rotation-angle").val(Math.round(fixedAngle));
        }

        function stopRotation() {
            if (isDragging) {
                isDragging = false;
                currentAngle = cropper.getData().rotate; // Save last rotation state
            }
        }

        // **Bind events for both desktop and mobile**
        $("#rotation-wheel").on("mousedown touchstart", startRotation);
        $(document).on("mousemove touchmove", rotate);
        $(document).on("mouseup touchend", stopRotation);

        // **Manual Angle Input**
        $("#rotation-angle").on("input", function () {
            let angle = parseInt($(this).val()) || 0;
            angle = Math.min(360, Math.max(0, angle)); // Keep within 0-360

            // Rotate image & knob
            cropper.rotateTo(angle);
            $("#rotation-wheel").css("transform", `rotate(${angle}deg)`);
        });
    });
    </script>
@endsection