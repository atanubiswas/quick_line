@extends('layouts.admin_layout')
@section('title', "View Case Studies")
@section('extra_css')
    <style type="text/css">
        
        option:disabled {
            color: #cfcfcf;
        }
        .btn-custom-class {
            width:30px;
            max-width: 30px;
            margin: 2px 0;
        }
        .delete_case_study_row{
            background-color: #ffcece;
        }
        label em {
            color: #FF0000;
        }

        .modal-dialog {
            max-width: 80%;
        }

        #doc_image_view .modal-dialog {
            max-width: 100%;
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
        .rotation-wheel-class {
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

        .assigner-study-section, .current-study-section, .study-section {
            position: relative;
            border: 1px solid #ccc;
            padding: 15px;
            margin-bottom: 10px;
            border-radius: 5px;
            background-color: #f9f9f9;
        }

        .assigner-study-section .buttons, .study-section .buttons {
            position: absolute;
            top: 10px;
            right: 10px;
            display: flex;
            gap: 5px;
        }

        .d-none {
            display: none;
        }

        /* Responsive adjustments */
        @media (max-width: 576px) {
            .assigner-study-section, .study-section {
                padding-top: 40px; /* Ensure space for buttons */
            }
            .assigner-study-section .buttons, .study-section .buttons {
                top: 5px;
                right: 5px;
            }
        }
        .child-table {
            border-collapse: collapse;
            width: 100%;
        }
        .child-table th, .child-table td {
            border: 1px solid #ddd;
            padding: 5px;
            text-align: left;
        }
        .ui-state-active {
            background-color: #007bff !important;
            color: white !important;
        }
        .ui-state-default {
            background-color: #f1f1f1 !important;
            color: black !important;
        }
    </style>

    <!-- DataTables -->
    <link rel="stylesheet" href="{{asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{asset('plugins/select2/css/select2.min.css')}}">
    <link rel="stylesheet" href="{{asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.14.1/themes/base/jquery-ui.css">
    <!-- summernote -->
    <link rel="stylesheet" href="{{asset('plugins/summernote/summernote-bs4.min.css')}}">

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
                @if(in_array(auth()->user()->roles[0]->id, [1, 5, 6]))
                <div class="row">
                    <div class="col-sm-4">
                        <a href="{{ route("admin.viewCaseStudy", ['sdt'=>Carbon\Carbon::now()->format('Y-m-d'), 'edt'=>Carbon\Carbon::now()->format('Y-m-d')]) }}" class="btn btn-app bg-success">
                        <span class="badge bg-danger">{{ $todayCount }}</span>
                        <i class="fas fa-calendar-check"></i>Today
                        </a>
                        <a href="{{ route("admin.viewCaseStudy", ['sdt'=>Carbon\Carbon::now()->subDay()->format('Y-m-d'), 'edt'=>Carbon\Carbon::now()->subDay()->format('Y-m-d')]) }}" class="btn btn-app bg-primary">
                        <span class="badge bg-danger">{{ $yesterdayCount }}</span>
                        <i class="fas fa-calendar-day"></i>Yesterday
                        </a>
                        <a href="{{ route("admin.viewCaseStudy", ['sdt'=>Carbon\Carbon::now()->startOfWeek()->format('Y-m-d'), 'edt'=>Carbon\Carbon::now()->endOfWeek()->format('Y-m-d')]) }}" class="btn btn-app bg-orange">
                        <span class="badge bg-danger">{{ $weekCount }}</span>
                        <i class="fas fa-calendar-alt"></i>This Week
                        </a>
                        <a href="{{ route("admin.viewCaseStudy", ['sdt'=>Carbon\Carbon::now()->startOfMonth()->format('Y-m-d'), 'edt'=>Carbon\Carbon::now()->format('Y-m-d')]) }}" class="btn btn-app bg-warning">
                        <span class="badge bg-danger">{{ $monthCount }}</span>
                        <i class="fas fa-calendar-alt"></i>This Month
                        </a>
                    </div>
                    <div class="col-sm-6">
                        <a href="{{ route("admin.viewCaseStudy", ['sdt'=>Carbon\Carbon::now()->startOfMonth()->format('Y-m-d'), 'edt'=>Carbon\Carbon::now()->format('Y-m-d'), 'st'=>'active']) }}" class="btn btn-app bg-success">
                        <span class="badge bg-danger">{{ $activeCount }}</span>
                        <i class="fas fa-calendar-alt"></i>Active
                        </a>
                        <a href="{{ route("admin.viewCaseStudy", ['sdt'=>Carbon\Carbon::now()->format('Y-m-d'), 'edt'=>Carbon\Carbon::now()->format('Y-m-d'), 'st'=>1]) }}" class="btn btn-app bg-primary">
                        <span class="badge bg-danger">{{ $unreadCount }}</span>
                        <i class="fas fa-calendar-alt"></i>Unread
                        </a>
                        <a href="{{ route("admin.viewCaseStudy", ['sdt'=>Carbon\Carbon::now()->format('Y-m-d'), 'edt'=>Carbon\Carbon::now()->format('Y-m-d'), 'st'=>2]) }}" class="btn btn-app bg-warning">
                        <span class="badge bg-danger">{{ $pendingCount }}</span>
                        <i class="fas fa-calendar-alt"></i>Pending
                        </a>
                        <a href="{{ route("admin.viewCaseStudy", ['sdt'=>Carbon\Carbon::now()->format('Y-m-d'), 'edt'=>Carbon\Carbon::now()->format('Y-m-d'), 'st'=>3]) }}" class="btn btn-app bg-orange">
                        <span class="badge bg-danger">{{ $qaPendingCount }}</span>
                        <i class="fas fa-calendar-alt"></i>QA Pending
                        </a>
                        <a href="{{ route("admin.viewCaseStudy", ['sdt'=>Carbon\Carbon::now()->format('Y-m-d'), 'edt'=>Carbon\Carbon::now()->format('Y-m-d'), 'st'=>4]) }}" class="btn btn-app bg-info">
                        <span class="badge bg-danger">{{ $reWorkCount }}</span>
                        <i class="fas fa-calendar-alt"></i>Re-Work
                        </a>
                        <a href="{{ route("admin.viewCaseStudy", ['sdt'=>Carbon\Carbon::now()->format('Y-m-d'), 'edt'=>Carbon\Carbon::now()->format('Y-m-d'), 'st'=>5]) }}" class="btn btn-app bg-dark">
                        <span class="badge bg-danger">{{ $finishedCount }}</span>
                        <i class="fas fa-calendar-alt"></i>Finished
                        </a>
                    </div>
                    <div class="col-sm-2">
                        <a href="{{ route("admin.viewCaseStudy", ['sdt'=>Carbon\Carbon::now()->format('Y-m-d'), 'edt'=>Carbon\Carbon::now()->format('Y-m-d'), 'ty'=>'emr']) }}" class="btn btn-app bg-danger">
                        <span class="badge bg-success">{{ $emergencyCount }}</span>
                        <i class="fas fa-calendar-check"></i>Emergency
                        </a>
                    </div>
                </div>
                @endif
                <div class="row">
                    <div class="col-12">
                        <div class="card card-purple">
                            <div class="card-header">
                                @if(in_array(auth()->user()->roles[0]->id, [1, 3, 5, 6]))
                                <!-- Split dropdowns into two rows and add Modality dropdown -->
                                <div class="row mb-2">
                                    <div class="col-md-3">
                                        @if($roleId != 3)
                                        <div class="input-group">
                                            <select id="doctor_search" name="doctor_search" class="form-control select2" style="width: 100%;">
                                                <option value="">All Doctors</option>
                                                @foreach($doctors as $doctor)
                                                    <option value="{{$doctor->id}}">{{$doctor->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @endif
                                    </div>
                                    <div class="col-md-3">
                                        @if($roleId != 3)
                                        <div class="input-group">
                                            <select id="qc_search" name="qc_search" class="form-control select2" style="width: 100%;">
                                                <option value="">All Quality Controllers</option>
                                                @foreach($qualityControllers as $qualityController)
                                                    <option value="{{$qualityController->id}}">{{$qualityController->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @endif
                                    </div>
                                    <div class="col-md-3">
                                        @if($roleId != 3)
                                        <div class="input-group">
                                            <select id="centre" name="centre" class="form-control select2" style="width: 100%;">
                                                <option value="">All Centres</option>
                                                @foreach($Labrotories as $Labrotory)
                                                    <option value="{{$Labrotory->id}}">{{$Labrotory->lab_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-md-3">
                                        <div class="input-group">
                                            <select id="modality_search" name="modality_search" class="form-control select2" style="width: 100%;">
                                                <option value="">All Modalities</option>
                                                @foreach($modalities as $modality)
                                                    <option value="{{$modality->id}}">{{$modality->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="input-group">
                                            <select id="status_search" name="status_search" class="form-control select2" style="width: 100%;">
                                                <option value="">All Status</option>
                                                @foreach($status as $st)
                                                    <option value="{{$st->id}}">{{$st->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="input-group">
                                            <input type="text" id="daterange" class="form-control daterange" data-target="#datepicker"/>
                                            <input type="hidden" id="start_date" name="start_date" value="{{ Carbon\Carbon::now()->format('Y-m-d') }}">
                                            <input type="hidden" id="end_date" name="end_date" value="{{ Carbon\Carbon::now()->format('Y-m-d') }}">
                                            <button style="margin-left: 10px;" type="button" id="search_btn" name="search_btn" class="btn bg-gradient-orange float-right btn-sm">Search</button>
                                        </div>
                                    </div>
                                    <div class="col-md-3 text-right">
                                        <button type="button" id="add_case_study_btn" class="btn bg-gradient-success float-right btn-sm" data-toggle="modal" data-target="#add-case-study-modal">Add {{$pageName}}</button>
                                    </div>
                                </div>
                                @else
                                <div class="row">
                                    <div class="col-md-12">
                                        <h3 class="card-title" style="color: #fff;">View {{$pageName}} Data</h3>
                                    </div>
                                </div>
                                @endif
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body" id="main-card-body">
                                <table id="study_table" class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th style="width: 2%;">Sl. #</th>
                                            <th style="width: 6%;">Case Id</th>
                                            <th style="width: 7%;">Date & Time</th>
                                            <th style="width: 14%;">Patient Name</th>
                                            <th style="width: 15%;">Studies</th>
                                            <th style="width: 7%;">Modality</th>
                                            <th style="width: 5%;">Age Sex</th>
                                            <th style="width: 5%;">History</th>
                                            <th style="width: 5%;">Status</th>
                                            <th>Doctor</th>
                                            <th style="width: 100px;">Controls</th>
                                            @if(in_array(auth()->user()->roles[0]->id, [1, 5, 6]))
                                            <th>Centre</th>
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $slNo = 1; @endphp
                                        @foreach($CaseStudies as $caseStudy)
                                            @php
                                                if($caseStudy->doctor_id != null){
                                                    $doctor = $caseStudy->doctor->name;
                                                }
                                                else{
                                                    $doctor = "Not Assigned.";
                                                }
                                            @endphp
                                            <tr id="row-{{ $caseStudy->id }}"
                                            @if(!empty($caseStudy->deleted_at)) class="delete_case_study_row" 
                                            @elseif(!empty($caseStudy->assigner_id) && $caseStudy->study_status_id == 1 && $caseStudy->assigner_id == $authUserId) class="bg-gradient-warning text-black" 
                                            @elseif(!empty($caseStudy->assigner_id) && $caseStudy->study_status_id == 1 && $caseStudy->assigner_id != $authUserId) class="bg-gradient-teal text-black" 
                                            @elseif(!empty($caseStudy->qc_id) && $caseStudy->study_status_id == 3 && $caseStudy->qc_id == $authUserId) class="bg-gradient-warning text-black"
                                            @elseif(!empty($caseStudy->qc_id) && $caseStudy->study_status_id == 3 && $caseStudy->qc_id != $authUserId) class="bg-gradient-teal text-black" 
                                            @endif>
                                                <td>
                                                    @if(!empty($caseStudy->assigner_id))
                                                    <span title="@if($caseStudy->study_status_id==1) Open By: @else Assigned By: @endif{{ $caseStudy->assigner->name }}" class="badge text-black"><i class="fas fa-user"></i></span>
                                                    @endif
                                                    {{$slNo++}}
                                                </td>
                                                <td>{{$caseStudy->case_study_id}}</td>
                                                <td>{{ \Carbon\Carbon::parse($caseStudy->created_at)->format('jS M Y, g:i a') }}</td>
                                                <td>
                                                    <div>{{$caseStudy->patient->name}}</div>
                                                    @if($caseStudy->is_emergency == 1)
                                                    <div class="badge bg-gradient-danger"><i class="fas fa-info-circle me-1"></i> Emergency</div>
                                                    @endif
                                                    @if($caseStudy->is_post_operative == 1)
                                                    <div class="badge bg-gradient-orange"><i class="fas fa-info-circle me-1"></i> Post Operative</div>
                                                    @endif
                                                    @if($caseStudy->is_follow_up == 1)
                                                    <div class="badge bg-gradient-orange"><i class="fas fa-info-circle me-1"></i> Follow Up</div>
                                                    @endif
                                                    @if($caseStudy->is_subspecialty == 1)
                                                    <div class="badge bg-gradient-orange"><i class="fas fa-info-circle me-1"></i> Subspecialty</div>
                                                    @endif
                                                    @if($caseStudy->is_callback == 1)
                                                    <div class="badge bg-gradient-orange"><i class="fas fa-info-circle me-1"></i> Callback</div>
                                                    @endif
                                                </td>
                                                <td>
                                                    @foreach($caseStudy->study as $study)
                                                        {{ $study->type->name }}@if(!$loop->last), @endif
                                                    @endforeach
                                                </td>
                                                <td>{{ $caseStudy->modality->name }}</td>
                                                <td>{{$caseStudy->patient->age."/".strtoupper(substr($caseStudy->patient->gender,0, 1))}}</td>
                                                <td>{{$caseStudy->clinical_history}}</td>
                                                <td>
                                                    <span 
                                                        @if($caseStudy->study_status_id ==1)class="badge bg-gradient-danger" 
                                                        @elseif($caseStudy->study_status_id ==2)class="badge bg-gradient-indigo"
                                                        @elseif($caseStudy->study_status_id ==3)class="badge bg-gradient-indigo"
                                                        @elseif($caseStudy->study_status_id ==4)class="badge bg-gradient-orange"
                                                        @elseif($caseStudy->study_status_id ==5)class="badge bg-gradient-success"
                                                        @elseif($caseStudy->study_status_id ==6)class="badge bg-gradient-danger"
                                                        @endif>{{$caseStudy->status->name}}
                                                    </span>
                                                </td>
                                                <td>{!!$doctor!!}</td>
                                                <td>
                                                    @if(in_array(auth()->user()->roles[0]->id, [1, 5, 6]))
                                                        <button class="btn btn-custom-class btn-xs bg-gradient-purple assigner_view_image" title="View Images" data-pt-name="{{ $caseStudy->patient->name }}" data-index="{{ $caseStudy->id }}"><i class="fas fa-eye"></i></button>
                                                    @else
                                                        <button class="btn btn-custom-class btn-xs bg-gradient-purple doc_view_image" title="View Images" data-index="{{ $caseStudy->id }}"><i class="fas fa-eye"></i></button>
                                                    @endif
                                                    @if(!in_array(auth()->user()->roles[0]->id, [3]))
                                                    <button class="btn btn-custom-class btn-xs bg-gradient-blue view-case-btn" title="View Studies" data-index="{{ $caseStudy->id }}"><i class="fas fa-folder"></i></button>
                                                    @endif
                                                    @if(in_array(auth()->user()->roles[0]->id, [1, 5, 6]))
                                                    <button class="btn btn-custom-class btn-xs bg-gradient-orange view-timeline-btn" title="View Timeline" data-index="{{ $caseStudy->id }}"><i class="fas fa-history"></i></button>
                                                    @endif
                                                    @if(in_array(auth()->user()->roles[0]->id, [1, 3, 5, 6]) && $caseStudy->study_status_id == 5)
                                                    <button class="btn btn-custom-class btn-xs bg-gradient-success view-report-btn" title="View Report" data-index="{{ $caseStudy->id }}"><i class="fas fa-file-pdf"></i></button>
                                                    @endif
                                                    @if(in_array(auth()->user()->roles[0]->id, [1, 5, 6]) && in_array($caseStudy->study_status_id, [1, 2]))
                                                    <button class="btn btn-custom-class btn-xs bg-gradient-danger delete-case-btn" title="Delete Report" data-index="{{ $caseStudy->id }}"><i class="fas fa-trash"></i></button>
                                                    @endif
                                                    @if(in_array(auth()->user()->roles[0]->id, [1, 5, 6]) && in_array($caseStudy->study_status_id, [2, 4]))
                                                    <button class="btn btn-custom-class btn-xs bg-gradient-cyan copy-link-btn" title="Copy Link" data-index="{{ $caseStudy->id }}"><i class="fas fa-copy"></i></button>
                                                    @endif
                                                    @if(in_array(auth()->user()->roles[0]->id, [1, 3, 5, 6]))
                                                    <a href="{{ route('admin.downloadImagesZip', ['id' => $caseStudy->id]) }}" title="Download Images" class="btn btn-custom-class btn-xs bg-gradient-dark download-zip"><i class="fas fa-file-archive"></i></a>
                                                    @endif
                                                    <button class="btn btn-custom-class btn-xs bg-gradient-purple view-comments-btn" title="Case Comments" data-index="{{ $caseStudy->id }}"><i class="fas fa-comments"></i></button>
                                                    <button class="btn btn-custom-class btn-xs bg-gradient-orange attachment-btn position-relative" title="Attachments" data-index="{{ $caseStudy->id }}"> <i class="fas fa-paperclip"></i> @if(count($caseStudy->attachments) > 0) <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"> {{ count($caseStudy->attachments) }} </span> @endif </button>
                                                </td>
                                                @if(in_array(auth()->user()->roles[0]->id, [1, 5, 6]))
                                                <td>{{$caseStudy->laboratory->lab_name}}&nbsp;<i class="fas fa-info-circle me-1 text-info" style="cursor: pointer;" title="Phone Number: {{ $caseStudy->laboratory->lab_phone_number }}"></i></td>
                                                @endif
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
                                    <div class="col-md-7">
                                        @if($roleId == 3)
                                        <div class="form-group">
                                            <label for="centre">Centre Name</label>
                                            <input type="hidden" name="centre_id" id="centre_id" value="{{$centre_id}}">
                                            <label class="form-control"> {{ $centre_name }}</label>
                                        </div>
                                        @else
                                        <div class="form-group">
                                            <label for="centre">Select Centre <em>*</em></label>
                                            <select name="centre_id" id="centre_id" class="form-control" style="width: 100%;">
                                                <option value="">Select Centre</option>
                                                @foreach($Labrotories as $Labrotory)
                                                    <option value="{{$Labrotory->id}}">{{$Labrotory->lab_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @endIf
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="modality">Referred by</label>
                                            <input type="text" name="ref_by" id="ref_by" class="form-control" placeholder="Enter Referred By">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
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
                                        <div class="buttons">
                                            <button type="button" class="btn btn-success add-study"><i class="fas fa-plus"></i></button>
                                            <button type="button" class="btn btn-danger remove-study d-none"><i class="fas fa-minus"></i></button>
                                        </div>
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
                                                    <textarea name="description[]" class="form-control" placeholder="Enter Description"></textarea>
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
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <div class="upload-container">
                                                <!-- Browse Files Button -->
                                                <label for="uploadImages" class="upload-btn">
                                                    <i class="fas fa-folder-open"></i> Browse
                                                </label>
                                                <input type="file" id="uploadImages" multiple="multiple" accept="image/*" hidden>

                                                <!-- Camera Button (Shown Only on Mobile) -->
                                                <label for="cameraUpload" class="camera-btn">
                                                    <i class="fas fa-camera"></i>
                                                </label>
                                                <input type="file" id="cameraUpload" accept="image/*" capture="environment" hidden>
                                            </div>
                                            <div id="previewImages" class="d-flex flex-wrap mt-3"></div>
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
                                <div id="rotation-wheel" class="rotation-wheel-class">
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
            <!-- /.modal -->

            <div class="modal fade" id="assigner_image_view">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title assigner-modal-title">Case Details</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body assigner_image_view_body">
                            
                        </div>
                        <div class="modal-footer justify-content-between" style="display: block;">
                            <button type="button" class="btn btn-danger float-right" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.modal -->
            
            <div class="modal fade" id="doc_image_view">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Case Details</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body doc_image_view_body">
                            
                        </div>
                        <div class="modal-footer justify-content-between" style="display: block;">
                            <button type="button" class="btn btn-danger float-right" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.modal -->

            <div class="modal fade" id="case_study_attachment">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Case Attachments</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body case_study_attachment_body">
                            
                        </div>
                        <div class="modal-footer justify-content-between" style="display: block;">
                            <button type="button" class="btn btn-danger float-right" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.modal -->

            <div class="modal fade" id="case_study_comments">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Case Comments</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body case_study_comments_body">
                            
                        </div>
                        <div class="modal-footer justify-content-between" style="display: block;">
                            <button type="button" class="btn btn-danger float-right" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.modal -->

            <div class="modal fade" id="caseStudyModal" tabindex="-1" aria-labelledby="caseStudyModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="caseStudyModalLabel">Case Study Details</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" id="caseStudyModalBody">
                        <!-- AJAX content goes here -->
                    </div>
                    </div>
                </div>
            </div>
            <!-- Modal -->

            <div class="row" id="timeline_div">

            </div>

            <div class="row" id="report-row" style="display: none;">
                <div class="col-md-12">
                    <div class="card card-purple">
                        <div class="card-header">Report</div>
                        <div class="card-body" id="report_div">

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
    <!-- Summernote -->
    <script src="{{asset('plugins/summernote/summernote-bs4.min.js')}}"></script>

    <!-- CROPPER JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.js"></script>
    
    <!--COMPRESS JS -->
    <script src="https://cdn.jsdelivr.net/npm/compressorjs@1.2.1/dist/compressor.min.js"></script>

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

            const targetIndex = getUrlParam("d");

            if (targetIndex !== null) {
                setTimeout(function () {
                    const $button = $(`button.doc_view_image[data-index="${targetIndex}"]`).first();
                    console.log($button);
                    if ($button.length) {
                        $button.click();
                    }
                    else{
                        swal.fire({
                            title: 'Not Found.',
                            text: 'The Case you are looking for is not found, Please contact Quick Line Team for more Information.',
                            icon: 'warning',
                            confirmButtonText: 'OK'
                        });
                    }
                },500);
            }
            
            @if($roleId == 3)
                $.ajax({
                    url: "{{ route('get-modality') }}",
                    type: "POST",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "lab_id": {{ $centre_id }}
                    },
                    success: function (response) {
                        $('#modality').html(response).trigger('change');
                    }
                });
            @endif

            $(document).on('click', '.assigner_view_image', function() {
                allFiles = []; // Reset allFiles array
                const thisButton = $(this);
                thisButton.html('<i class="fas fa-spinner fa-spin"></i>');
                let case_study_id = $(this).data('index');
                let type = 'assigner';
                let patient_name = $(this).data('pt-name');
                $.ajax({
                    url: "{{ url('admin/get-case-study-images') }}",
                    type: "POST",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "case_study_id": case_study_id,
                        "type": type
                    },
                    success: function(response) {
                        thisButton.html('<i class="fas fa-eye"></i>');
                        $(".assigner_image_view_body").html(response);
                        $(".assigner-modal-title").html("Case Details of: " + patient_name);
                        $('#assigner_image_view').modal({
                            backdrop: 'static',
                            keyboard: false
                        });

                        $(".image-thumb-assigner").each(function() {
                            let imgSrc = $(this).attr("src");
                            fetch(imgSrc)
                                .then(response => response.blob())
                                .then(blob => {
                                    let filename = imgSrc.split('/').pop(); // extract filename from URL
                                    let file = new File([blob], filename, { type: blob.type });
                                    allFiles.push(file);
                                })
                                .catch(error => {
                                    console.error("Error fetching image:", error);
                                });
                        });
                        currentFile = 0;
                        if (cropper) {
                            cropper.destroy();
                        }

                        let image = document.getElementById("cropImage-assigner");
                        cropper = new Cropper(image, {
                            aspectRatio: NaN, // Free cropping
                            viewMode: 2, // Prevents overflow
                            autoCropArea: 1, // Ensures image fits well
                            responsive: true,
                            restore: false,
                            scalable: true,
                            zoomable: true,
                            rotatable: true,
                            movable: true,
                            autoCrop: false
                        });

                        // Resize Cropper to fit within the modal
                        setTimeout(() => {
                            cropper.resize();
                        }, 300);
                    },
                    error: function(response){
                        thisButton.html('<i class="fas fa-eye"></i>');
                        $("#search_btn").html("Search");
                    }
                });
            });

            $(document).on('click', '.doc_view_image', function() {
                var tr = $(this).closest('tr');
                let case_study_id = $(this).data('index');
                let type = 'doc';
                $.ajax({
                    url: "{{ url('admin/get-case-study-images') }}",
                    type: "POST",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "case_study_id": case_study_id,
                        "type": type
                    },
                    success: function(response) {
                        $(".doc_image_view_body").html(response);
                        tr.addClass('bg-gradient-warning text-black');

                        $('#doc_image_view').modal('show');
                        if (cropper) {
                            cropper.destroy();
                        }

                        let image = document.getElementById("cropImage-doctor");
                        cropper = new Cropper(image, {
                            aspectRatio: NaN, // Free cropping
                            viewMode: 2, // Prevents overflow
                            autoCropArea: 1, // Ensures image fits well
                            responsive: true,
                            restore: false,
                            scalable: true,
                            zoomable: true,
                            rotatable: true,
                            movable: true,
                            autoCrop: false,
                            dragMode: 'move'
                        });

                        // Resize Cropper to fit within the modal
                        setTimeout(() => {
                            cropper.resize();
                        }, 300);
                    },
                    error: function(response){
                        $("#search_btn").html("Search");
                    }
                });
            });

            $(document).on('hidden.bs.modal', '#doc_image_view', function () {
                case_study_id = $('#unique_case_study_id').val();
                $.ajax({
                    url: "{{ route('admin.reset-assigner-id') }}",
                    type: "POST",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "case_id": case_study_id
                    },
                    success: function (response) {
                        location.reload();
                    },
                    error: function (response) {
                        location.reload();
                    }
                });
            });

            function getUrlParam(param) {
                const urlParams = new URLSearchParams(window.location.search);
                return urlParams.get(param);
            }

            const startDateVal = getUrlParam('sdt');
            const endDateVal = getUrlParam('edt');
            const centreIdVal = getUrlParam('cid');
            const doctorIdVal = getUrlParam('did');
            const qcIdVal = getUrlParam('qid');
            const statusVal = getUrlParam('st');

            // Always FORMAT the moment before using
            const sdt = startDateVal ? moment(startDateVal, 'YYYY-MM-DD').format('YYYY-MM-DD') : moment().format('YYYY-MM-DD');
            const edt = endDateVal ? moment(endDateVal, 'YYYY-MM-DD').format('YYYY-MM-DD') : moment().format('YYYY-MM-DD');

            // Set the formatted values into inputs
            $('#start_date').val(sdt);
            $('#end_date').val(edt);

            $('#centre').val(centreIdVal);
            $('#doctor_search').val(doctorIdVal);
            $('#qc_search').val(qcIdVal);
            $('#status_search').val(statusVal);

            // Initialize daterangepicker
            $('#daterange').daterangepicker({
                startDate: startDateVal ? moment(startDateVal, 'YYYY-MM-DD') : moment(),
                endDate: endDateVal ? moment(endDateVal, 'YYYY-MM-DD') : moment(),
                maxDate: moment(),
                applyButtonClasses: 'btn bg-gradient-purple',
                cancelButtonClasses: 'btn bg-gradient-danger',
                locale: {
                    format: 'DD/MM/YYYY'
                }
            }, function(start, end, label) {
                $('#start_date').val(start.format('YYYY-MM-DD'));
                $('#end_date').val(end.format('YYYY-MM-DD'));
            });

            $("#search_btn").click(function () {
                $(this).html('Search <i class="fas fa-spinner fa-spin"></i>');
                let start_date = $('#start_date').val();
                let end_date = $('#end_date').val();
                let centre_id = $('#centre').val();
                let doctor_id = $('#doctor_search').val();
                let qc_id = $('#qc_search').val();
                let status = $('#status_search').val();
                let modality_id = $('#modality_search').val(); // <-- Get selected modality
                
                $.ajax({
                    url: "{{ url('admin/get-case-study-search-result') }}",
                    type: "POST",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "start_date": start_date,
                        "end_date": end_date,
                        "centre_id": centre_id,
                        "doctor_id": doctor_id,
                        "qc_id": qc_id,
                        "status": status,
                        "modality_id": modality_id // <-- Send modality id
                    },
                    success: function(response) {
                        $("#search_btn").html("Search");
                        $("#main-card-body").html(response);
                        study_table = $('#study_table').DataTable({
                            "paging": true,
                            "lengthChange": true,
                            "searching": true,
                            "ordering": true,
                            "info": true,
                            "autoWidth": false,
                            "responsive": true,
                            "lengthMenu": [[10, 25, 50, 100, 500, -1], [10, 25, 50, 100, 500, "All"]],
                            "order": [[0, 'asc']],
                            rowId: function(data) {
                                return 'row-' + data.id; // Ensuring a unique ID for each row
                            }
                        });
                    },
                    error: function(response){
                        $("#search_btn").html("Search");
                    }
                });
            });

            $("#study-sections").on("click", ".add-study", function () {
                let newSection = $(".study-section").first().clone(); // Clone the first section

                // Clear values in the cloned section
                newSection.find("select").val(""); // Reset dropdown
                newSection.find("textarea").val(""); // Reset textareas

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

            $(document).on("click", ".assigner-add-study", function () {
                let newSection = $(".assigner-study-section").first().clone(); // Clone the first section

                // Clear values in the cloned section
                newSection.find("select").val(""); // Reset dropdown
                newSection.find("textarea").val(""); // Reset textareas

                // Show the minus button in the new section
                newSection.find(".assigner-remove-study").removeClass("d-none");

                // Append new section with animation
                newSection.hide().appendTo("#assigner-study-sections").fadeIn(300);
            });

            // Function to remove a study section
            $(document).on("click", ".assigner-remove-study", function () {
                if ($(".assigner-study-section").length > 1) { // Prevent removing the last section
                    $(this).closest(".assigner-study-section").fadeOut(300, function () {
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
                    const fileSizeMB = file.size / (1024 * 1024); // Convert bytes to MB

                    const processFile = function (finalFile) {
                        let fileIndex = allFiles.length;
                        allFiles.push(finalFile);

                        const reader = new FileReader();
                        reader.onload = function (e) {
                            $("#previewImages").append(`
                                <div class="m-2 position-relative d-inline-block" id="preview-${fileIndex}">
                                    <img src="${e.target.result}" id="img-${fileIndex}" class="img-thumbnail preview-img" width="100" data-file-index="${fileIndex}" height="100" style="cursor: pointer;">
                                    <button type="button" class="close-btn btn btn-danger btn-sm" data-index="${fileIndex}" style="position: absolute; top: 5px; right: 5px;">×</button>
                                </div>
                            `);
                        };
                        reader.readAsDataURL(finalFile);
                    };

                    if (fileSizeMB > 1) {
                        // Compress only if > 1MB
                        new Compressor(file, {
                            quality: 0.6,
                            maxWidth: 1200,
                            success: function (compressedBlob) {
                                const compressedFile = new File([compressedBlob], file.name, {
                                    type: compressedBlob.type,
                                    lastModified: Date.now(),
                                });
                                processFile(compressedFile);
                            },
                            error: function (err) {
                                console.error("Compression error:", err.message);
                                processFile(file); // fallback to original
                            },
                        });
                    } else {
                        // No compression needed
                        processFile(file);
                    }
                });

                $(this).val(""); // Allow re-selection of same files
            });

            $("#previewImages").on("click", ".close-btn", function () {
                let index = $(this).data("index");
                $("#preview-" + index).remove();
                allFiles[index] = null; // Mark file as removed
            });

            $(document).on("click", ".existing-img-close-btn", function () {
                let index = $(this).data("index");
                $("#existing-img-preview-" + index).remove();
                allFiles[index] = null; // Mark file as removed
                let isNoImage = true;
                allFiles.forEach((file, index) => {
                    if (file !== null) {
                        noImage = false;
                    }
                });
                
                if(isNoImage === true){
                    const noImage = '{{ asset('images/no-img.jpg')}}'; 
                    $("#cropImage-assigner").attr("src", noImage);
                    if (cropper) {
                        cropper.destroy();
                    }
                    let image = document.getElementById("cropImage-assigner");
                    cropper = new Cropper(image, {
                        aspectRatio: NaN, // Free cropping
                        viewMode: 2, // Prevents overflow
                        autoCropArea: 1, // Ensures image fits well
                        responsive: true,
                        restore: false,
                        scalable: true,
                        zoomable: true,
                        rotatable: true,
                        movable: true,
                        autoCrop: false
                    });

                    // Resize Cropper to fit within the modal
                    setTimeout(() => {
                        cropper.resize();
                    }, 300);
                }
            });

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
                currentFile = $(this).data("file-index"); // Store file index
                
                $("#cropImage").attr("src", imgSrc);
                
                $("#cropModal").modal("show");

                $("#cropModal").on("shown.bs.modal", function () {
                    if (cropper) {
                        cropper.destroy();
                    }

                    let image = document.getElementById("cropImage");
                    cropper = new Cropper(image, {
                        aspectRatio: NaN, // Free cropping
                        viewMode: 2, // Prevents overflow
                        autoCropArea: 1, // Ensures image fits well
                        responsive: true,
                        restore: false,
                        scalable: true,
                        zoomable: true,
                        rotatable: true,
                        movable: true,
                        autoCrop: false
                    });

                    // Resize Cropper to fit within the modal
                    setTimeout(() => {
                        cropper.resize();
                    }, 300);
                });
            });

        $(document).on("click", ".image-thumb-assigner", function () {
            let imgSrc = $(this).attr("src");
            $("#cropImage-assigner").attr("src", imgSrc);

            if (cropper) {
                cropper.destroy();
            }
            currentFile = $(this).data("file-index");
            
            let image = document.getElementById("cropImage-assigner");
            cropper = new Cropper(image, {
                aspectRatio: NaN, // Free cropping
                viewMode: 2, // Prevents overflow
                autoCropArea: 1, // Ensures image fits well
                responsive: true,
                restore: false,
                scalable: true,
                zoomable: true,
                rotatable: true,
                movable: true,
                autoCrop: false
            });

            // Resize Cropper to fit within the modal
            setTimeout(() => {
                cropper.resize();
            }, 300);
        });

        $(document).on("click", ".image-thumb-doctor", function () {
            let imgSrc = $(this).attr("src");
            $("#cropImage-doctor").attr("src", imgSrc);

            if (cropper) {
                cropper.destroy();
            }

            let image = document.getElementById("cropImage-doctor");
            cropper = new Cropper(image, {
                aspectRatio: NaN, // Free cropping
                viewMode: 2, // Prevents overflow
                autoCropArea: 1, // Ensures image fits well
                responsive: true,
                restore: false,
                scalable: true,
                zoomable: true,
                rotatable: true,
                movable: true,
                autoCrop: false,
                dragMode: 'move'
            });

            // Resize Cropper to fit within the modal
            setTimeout(() => {
                cropper.resize();
            }, 300);
        });

        $(document).on("click", "#flipHorizontal, #flipHorizontal-doctor", function () {
            scaleX = scaleX === 1 ? -1 : 1; // Toggle between 1 and -1
            cropper.scaleX(scaleX);
        });

        $(document).on("click", "#flipVertical, #flipVertical-doctor", function () {
            scaleY = scaleY === 1 ? -1 : 1; // Toggle between 1 and -1
            cropper.scaleY(scaleY);
        });
        
        $(document).on("click", ".cropper-drag-box", function () {
            if (cropper) {
                if (isCropping) {
                    cropper.clear(); // Hide the crop box
                }
            }
            isCropping = !isCropping;
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

        $(document).on("click", "#zoomIn, #zoomIn-doctor", function () {
            cropper.zoom(0.1);
        });

        $(document).on("click", "#zoomOut, #zoomOut-doctor", function () {
            cropper.zoom(-0.1);
        });

        $(document).on("click", "#moveLeft, #moveLeft-doctor", function () {
            cropper.move(-10, 0);
        });

        $(document).on("click", "#moveRight, #moveRight-doctor", function () {
            cropper.move(10, 0);
        });

        $(document).on("click", "#moveUp, #moveUp-doctor", function () {
            cropper.move(0, -10);
        });

        $(document).on("click", "#moveDown, #moveDown-doctor", function () {
            cropper.move(0, 10);
        });

        $(document).off("keydown").on("keydown", function (e) {
            const keys = ["ArrowLeft", "ArrowRight", "ArrowUp", "ArrowDown"];
            const $target = $(e.target);

            // Check if the focus is inside an input field or editable area (like Summernote)
            const isEditable = $target.is("input, textarea, select, [contenteditable=true]") ||
                            $target.closest("[contenteditable=true]").length > 0;

            if (keys.includes(e.key) && !isEditable) {
                e.preventDefault(); // Prevent scroll only when not editing

                switch (e.key) {
                    case "ArrowLeft":
                        $("#moveLeft, #moveLeft-doctor").click();
                        break;
                    case "ArrowRight":
                        $("#moveRight, #moveRight-doctor").click();
                        break;
                    case "ArrowUp":
                        $("#moveUp, #moveUp-doctor").click();
                        break;
                    case "ArrowDown":
                        $("#moveDown, #moveDown-doctor").click();
                        break;
                }
            }
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
        
        $("#cropSave").click(function () {
            cropper.crop(); // Ensure cropping is active
            let canvas = cropper.getCroppedCanvas(); // Get the cropped canvas
            let croppedImage = canvas.toDataURL("image/png"); // Convert to Base64

            let imgSelector = `#img-${currentFile}`;
            $(imgSelector).attr("src", croppedImage);
            $("#cropModal").modal("hide");

            // Find the original file from allFiles
            let originalFile = allFiles[currentFile];
            if (!originalFile) {
                console.error("Original file not found!");
                return;
            }

            // Convert Base64 to Blob
            let croppedBlob = dataURLtoBlob(croppedImage);

            // Create a new File object with the original name and same type
            let croppedFile = new File([croppedBlob], originalFile.name, { type: originalFile.type });

            // Replace the original file in allFiles with the cropped file
            allFiles[currentFile] = croppedFile;
        });

        function dataURLtoBlob(dataURL) {
            let arr = dataURL.split(','),
                mime = arr[0].match(/:(.*?);/)[1],
                bstr = atob(arr[1]),
                n = bstr.length,
                u8arr = new Uint8Array(n);

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

        var study_table = $('#study_table').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
            "lengthMenu": [[10, 25, 50, 100, 500, -1], [10, 25, 50, 100, 500, "All"]],
            "order": [[0, 'asc']],
            rowId: function(data) {
                return 'row-' + data.id; // Ensuring a unique ID for each row
            }
        });

        $(document).on('click', '.view-case-btn', function () {
            var tr = $(this).closest('tr');
            var row = study_table.row(tr);
            var case_study_id = $(this).data('index');
            var button = $(this);

            // Detect screen width
            var isMobile = window.innerWidth <= 768;

            if (!isMobile) {
                // DESKTOP behavior: toggle child row
                if (row.child.isShown()) {
                    row.child.hide();
                    tr.removeClass('bg-gradient-warning text-black');
                    $.ajax({
                        url: "{{ route('admin.reset-assigner-id') }}",
                        type: "POST",
                        data: {
                            "_token": "{{ csrf_token() }}",
                            "case_id": case_study_id
                        },
                        success: function (response) {
                            
                        }
                    });
                    button.html('<i class="fas fa-folder"></i>');
                } 
                else {
                    $.ajax({
                        url: "{{ route('admin.get-all-studies') }}",
                        type: "POST",
                        data: {
                            "_token": "{{ csrf_token() }}",
                            "case_id": case_study_id
                        },
                        success: function (response) {
                            row.child(response).show();
                            tr.addClass('bg-gradient-warning text-black');
                            button.html('<i class="fas fa-folder-open"></i>');
                        }
                    });
                }
            } 
            else {
                // MOBILE behavior: open modal
                $.ajax({
                    url: "{{ route('admin.get-all-studies') }}",
                    type: "POST",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "case_id": case_study_id
                    },
                    success: function (response) {
                        $('#caseStudyModalBody').html(response);
                        $('#caseStudyModal').modal('show');
                    }
                });
            }
        });

        $('#caseStudyModal').on('hidden.bs.modal', function () {
            $.ajax({
                url: "{{ route('admin.reset-assigner-id') }}",
                type: "POST",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "case_id": case_study_id
                },
                success: function (response) {
                    
                }
            });
        });

        function formatChildRow(case_study_id) {
            $.ajax({
                url: "{{ route('admin.get-all-studies') }}",
                type: "POST",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "case_id": case_study_id
                },
                success: function (response) {
                    return response;
                }
            });
        }

        @if($roleId != 3)
        $('#centre_id').select2({
            dropdownParent: $('#add-case-study-modal'),
            theme: 'bootstrap4',
            placeholder: '-- Select Centre --',
            tags: true,
            allowClear: true
        });
        @endif

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
                        $('.study_id').html(response);
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
            startAngle = getAngle(event, $(".rotation-wheel-class")[0]);
            event.preventDefault(); // Prevent scrolling on mobile
        }

        function normalizeAngle(angle) {
            return (angle + 360) % 360; // Ensures angle stays between 0-360
        }

        function rotate(event) {
            if (!isDragging) return;
            let newAngle = getAngle(event, $(".rotation-wheel-class")[0]);
            let rotation = newAngle - startAngle + currentAngle;

            // Normalize the angle to always stay between 0-360
            let fixedAngle = normalizeAngle(rotation);

            // Rotate image using Cropper.js
            cropper.rotateTo(fixedAngle);

            // Rotate the knob
            $(".rotation-wheel-class").css("transform", `rotate(${fixedAngle}deg)`);

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
        // $(".rotation-wheel-class").on("mousedown touchstart", startRotation);
        $(document).on("mousedown touchstart", ".rotation-wheel-class", startRotation);
        $(document).on("mousemove touchmove", ".rotation-wheel-class", rotate);
        $(document).on("mouseup touchend", ".rotation-wheel-class", stopRotation);

        // **Manual Angle Input**
        $(document).on("input", "#rotation-angle",function () {
            let angle = parseInt($(this).val()) || 0;
            angle = Math.min(360, Math.max(0, angle)); // Keep within 0-360

            // Rotate image & knob
            cropper.rotateTo(angle);
            $(".rotation-wheel-class").css("transform", `rotate(${angle}deg)`);
        });
        
        $(document).on("click", '.view-report-btn', function(){
            $("#report-row").show(500);
            $("#report_div").html('');
            $(this).html('<i class="fas fa-spinner fa-spin"></i>');
            var case_study_id = $(this).data("index");
            var form_data = new FormData();
            form_data.append('case_study_id', case_study_id);

            $.ajax({
                url: '{{url("admin/case-study-report")}}',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                type: 'post',
                success: function (data) {
                    $(".view-report-btn").html('<i class="fas fa-file-pdf"></i>');
                    $("#report_div").html(data);
                    scrollToAnchor("view_report");
                },
                error: function (data) {
                    $(".view-report-btn").html('<i class="fas fa-file-pdf"></i>');
                    printErrorMsg("Somthing went wrong! Reload the page.");
                }
            });
        });

        $(document).on("click", '.view-timeline-btn',function () {
            const thisButton = $(this);
            thisButton.html('<i class="fas fa-spinner fa-spin"></i>');
            $("#timeline_div").html('');
            var case_study_id = $(this).data("index");
            var form_data = new FormData();
            form_data.append('case_study_id', case_study_id);

            $.ajax({
                url: '{{url("admin/case-study-timeline")}}',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                type: 'post',
                success: function (data) {
                    thisButton.html('<i class="fas fa-history"></i>');
                    $("#timeline_div").html(data);
                    scrollToAnchor("view_timeline");
                },
                error: function (data) {
                    thisButton.html('<i class="fas fa-history"></i>');
                    printErrorMsg("Somthing went wrong! Reload the page.");
                }
            });
        });

        $(document).on("click", '.delete-case-btn',function () {
            var case_study_id = $(this).data("index");
            Swal.fire({
                icon: 'error',
                title: "Are you sure?",
                text: "Write 'Delete' on the Box and Click Confirm Delete, To Delete The Case Study.",
                input: "text",
                inputAttributes: {
                    autocapitalize: "off"
                },
                showCancelButton: true,
                confirmButtonText: "Confirm Delete",
                showLoaderOnConfirm: true,
                preConfirm: async (login) => {
                    if(login !== 'Delete'){
                        Swal.showValidationMessage(`
                            To Delete The Case Study, You need to Write 'Delete' in the Box.
                        `);
                    }
                }
            }).then((result) => {
                if(result.isConfirmed === true && result.value === 'Delete'){
                    $.ajax({
                        url: '{{url("admin/delete-case-study")}}',
                        type: 'POST',
                        data: {
                            "_token": "{{ csrf_token() }}",
                            "case_study_id": case_study_id
                        },
                        success: function (data) {
                            if(data.status == 'success'){
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Deleted!',
                                    text: data.message,
                                    showConfirmButton: false,
                                    timer: 1500
                                });
                                setTimeout(function(){
                                    location.reload();
                                }, 2000);
                            }else{
                                Swal.fire({
                                    title: 'Error!',
                                    html: data.message,
                                    icon: 'error',
                                    confirmButtonText: 'Close',
                                    timer: 5000,
                                    timerProgressBar: true,
                                }).then((result) => {
                                    location.reload();
                                });
                            }
                        },
                        error: function (data) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: "Somthing went wrong! Reload the page.",
                            });
                        }
                    });
                }
            });
        });

        $(document).on("click", '#save_this_image', function() {
            cropper.crop(); // Ensure cropping is active
            let canvas = cropper.getCroppedCanvas(); // Get the cropped canvas
            let croppedImage = canvas.toDataURL("image/png"); // Convert to Base64

            let imgSelector = `#existing_image_${currentFile}`;
            $(imgSelector).attr("src", croppedImage);
            $("#cropImage-assigner").attr("src", croppedImage);

            if (cropper) {
                cropper.destroy();
            }
            let image = document.getElementById("cropImage-assigner");
            cropper = new Cropper(image, {
                aspectRatio: NaN, // Free cropping
                viewMode: 2, // Prevents overflow
                autoCropArea: 1, // Ensures image fits well
                responsive: true,
                restore: false,
                scalable: true,
                zoomable: true,
                rotatable: true,
                movable: true,
                autoCrop: false
            });

            // Find the original file from allFiles
            let originalFile = allFiles[currentFile];
            if (!originalFile) {
                console.error("Original file not found!");
                return;
            }

            // Convert Base64 to Blob
            let croppedBlob = dataURLtoBlob(croppedImage);
            // Create a new File object with the original name and same type
            let croppedFile = new File([croppedBlob], originalFile.name, { type: originalFile.type });

            // Replace the original file in allFiles with the cropped file
            allFiles[currentFile] = croppedFile;
            
        });

        $(document).on("change", "#existingUploadImages", function (event) {
            let files = event.target.files;

            $.each(files, function (index, file) {
                const fileSizeMB = file.size / (1024 * 1024); // Convert bytes to MB

                const processFile = function (finalFile) {
                    let fileIndex = allFiles.length;
                    allFiles.push(finalFile); // Add to global array

                    let reader = new FileReader();
                    reader.onload = function (e) {
                        $(".existing-image-contener").append(`
                            <div class="m-2 position-relative d-inline-block" id="existing-img-preview-${fileIndex}">
                                <img src="${e.target.result}" data-file-index="${fileIndex}" id="existing_image_${fileIndex}" height="160px" style="padding:5px; cursor:pointer" class="image-thumb-assigner" />
                                <button type="button" class="existing-img-close-btn btn btn-danger btn-sm" data-index="${fileIndex}" style="position: absolute; top: 5px; right: 5px; border-radius: 30px; height: 20px; width: 20px; display: flex; justify-content: center; align-items: center; padding: 0; font-size: 14px;">×</button>
                            </div>
                        `);
                    };
                    reader.readAsDataURL(finalFile);
                };

                if (fileSizeMB > 1) {
                    new Compressor(file, {
                        quality: 0.6,
                        maxWidth: 1200,
                        success: function (compressedBlob) {
                            const compressedFile = new File([compressedBlob], file.name, {
                                type: compressedBlob.type,
                                lastModified: Date.now(),
                            });
                            processFile(compressedFile);
                        },
                        error: function (err) {
                            console.error("Compression error:", err.message);
                            processFile(file); // fallback to original
                        }
                    });
                } else {
                    processFile(file); // no compression needed
                }
            });

            $(this).val(""); // allow re-selection
        });

        $(document).on("click", "#update_study_image", function () {
            $(this).html('Uploading <i class="fas fa-spinner fa-spin"></i>');
            case_study_id = $(this).data("index");
            let form_data = new FormData();
            allFiles.forEach((file, index) => {
                if (file) {
                    form_data.append("images[]", file);
                }
            });
            form_data.append("case_study_id", case_study_id);
            $.ajax({
                url: '{{url("admin/update-case-study-image")}}',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                type: 'post',
                success: function (data) {
                    $('#update_study_image').html('Update Images');
                    if ($.isEmptyObject(data.error)) {
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
                        printSuccessMsg(data.success, params);
                    } else {
                        printErrorMsg(data.error);
                    }
                },
                error: function (data) {
                    $('#update_study_image').html('Update Images');
                }
            });
        });

        $(document).on("click", ".download-zip", function () {
            let $btn = $(this);
            $btn.html('<i class="fas fa-spinner fa-spin"></i>');
            $btn.prop('disabled', true);

            // Reset button after 3 seconds
            setTimeout(function () {
                $btn.html('<i class="fas fa-file-archive"></i>');
                $btn.prop('disabled', false);
            }, 3000);
        });

        $(document).on("click", ".attachment-btn", function () {
            var tr = $(this).closest('tr');
            let case_study_id = $(this).data("index");
            let $btn = $(this);
            $btn.html('<i class="fas fa-spinner fa-spin"></i>');
            let form_data = new FormData();
            form_data.append("case_study_id", case_study_id);
            $.ajax({
                url: '{{url("admin/get-case-study-attachments")}}',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                type: 'post',
                success: function (data) {
                    $btn.html('<i class="fas fa-paperclip"></i>');
                    if ($.isEmptyObject(data.error)) {
                        $(".case_study_attachment_body").html(data);
                        $("#case_study_attachment").modal("show");
                    } else {
                        printErrorMsg(data.error);
                    }
                },
                error: function (data) {
                    $btn.html('<i class="fas fa-paperclip"></i>');
                }
            });
        });

        $('#case_study_attachment').on('hidden.bs.modal', function () {
            @if(in_array($roleId, [1, 5, 6]))
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
                const url = new URL(window.location.href);
                Object.entries(params).forEach(([key, value]) => {
                    url.searchParams.set(key, value);
                });
                url.searchParams.set('_', Date.now());
                window.location.href = url.toString();
            @else
                // For other roles, just reload the page
                location.reload();
            @endif
        });

        $(document).on('click', '.upload-attachment-btn', function() {
            let $btn = $(this);
            $btn.html('<i class="fas fa-spinner fa-spin"></i> Uploading...');
            var files = $("#attachment")[0].files;
            
            if(files.length == 0){
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Nothing to Upload.',
                });
                $btn.html('Upload');
                return false;
            }
            
            var formData = new FormData();
            var attachments = [];
            var case_study_id = $(this).data("index");
            Array.from(files).forEach(function(file) {
                formData.append('attachments[]', file);
            });
            formData.append('case_study_id', case_study_id);
            formData.append('_token', '{{ csrf_token() }}');
            $.ajax({
                url: '{{ route('admin.insertAttachments') }}',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(data) {
                    $btn.html('Upload');
                    $("#attachment").val('');
                    if ($.isEmptyObject(data.error)) {
                        $(".view_attachments_div").html(data);
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Error uploading attachments. You can only Upload Images and PDF files.',
                        });
                    }
                },
                error: function(data) {
                    $btn.html('Upload');
                    $("#attachment").val('');
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Error uploading attachments. You can only Upload Images and PDF files.',
                    });
                }
            });
        });

        $(document).on('click', '.view-comments-btn', function() {
            let $btn = $(this);
            $btn.html('<i class="fas fa-spinner fa-spin"></i>');
            var case_study_id = $(this).data("index");
            $.ajax({
                url: '{{ route('admin.getCaseComments') }}',
                type: 'POST',
                data: {
                    "_token": "{{ csrf_token() }}",
                    "case_study_id": case_study_id,
                    "view_add_comment": @if($roleId !=3) true @else false @endif
                },
                success: function(response) {
                    $btn.html('<i class="fas fa-comments"></i>');
                    $(".case_study_comments_body").html(response);
                    $("#case_study_comments").modal("show");
                },
                error: function(xhr, status, error) {
                    $btn.html('<i class="fas fa-comments"></i>');
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Error fetching comments. Please try again.',
                    });
                }
            });
        });

        $(document).on('click', '.change_status_btn',function () {
            var btn = $(this);
            btn.html('<i class="fas fa-spinner fa-spin"></i>');
            var caseId = $(this).data('case-id');
            var statusId = $("#study_status_id_"+caseId).val();
            var secondOpnionDoctorId = $("#second_opnion_assign_doctor_"+caseId).val();
            
            if(statusId == "") {
                swal.fire({
                    title: "Error!",
                    text: "Please Select Status first!",
                    icon: "error",
                    confirmButtonText: "OK"
                });
                return false;
            } 
            if (statusId == 2 && secondOpnionDoctorId == "") {
                swal.fire({
                    title: "Error!",
                    text: "Please Select 2nd Opnion Doctor!",
                    icon: "error",
                    confirmButtonText: "OK"
                });
                return false;
            } else {
                swal.fire({
                    title: "Are you sure?",
                    text: "You want to change the status of this case!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, Change It!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ url('admin/update-study-status') }}",
                            type: "POST",
                            data: {
                                status_id: statusId,
                                case_study_id: caseId,
                                second_opnion_doctor_id: secondOpnionDoctorId,
                                _token: "{{ csrf_token() }}"
                            },
                            success: function (data) {
                                btn.html('Update Status');
                                printSuccessMsg(data.message);
                            },
                            error: function (data) {
                                btn.html('Update Status');
                                printErrorMsg(data.error);
                            }
                        });
                    } else {
                        btn.html('Update Status');
                    }
                });
            }
        });

        $(document).on('change', '.study_status_id', function () {
            var caseId = $(this).data('case-id');
            var statusId = $(this).val();
            if (statusId == 2) {
                $("#second_opnion_assign_doctor_"+caseId).show('slow');
            } else {
                $("#second_opnion_assign_doctor_"+caseId).hide('slow');
            }
        });

        $(document).on('change', '.assign_doctor', function () {
            var thisSelect = $(this);
            var doctorId = $(this).val();
            var doctorName =  $(this).find(':selected').text();
            var caseId = $(this).attr('date-case-id');
            Swal.fire({
                title: "Are you sure?",
                text: "You want to Assign " + doctorName + " to this case!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, Assign It!"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ url('admin/assign-doctor') }}",
                        type: "POST",
                        data: {
                            doctor_id: doctorId,
                            case_id: caseId,
                            _token: "{{ csrf_token() }}"
                        },
                        success: function (data) {
                            printSuccessMsg(data.success);
                        }
                    });
                }
                else {
                    thisSelect.val('');
                }
            });
        });

        $(document).on('click', '.copy-link-btn', function () {
            const index = $(this).data('index');
            const url = `${window.location.origin}/admin/view-case-study?d=${index}`;

            navigator.clipboard.writeText(url).then(function () {
            // Success toast
            Swal.fire({
                icon: 'success',
                title: 'Copied!',
                text: 'URL has been copied to clipboard.',
                footer: `<code>${url}</code>`,
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true
            });
            }, function () {
            // Fallback if clipboard copy fails
            Swal.fire({
                icon: 'error',
                title: 'Error! Could not copy the URL',
                html: `
                <p>Copy the URL manually:</p>
                <input type="text" id="copyFallback" class="swal2-input" value="${url}" readonly>
                `,
                didOpen: () => {
                const input = document.getElementById('copyFallback');
                input.focus();
                input.select();
                },
                confirmButtonText: 'OK'
            });
            });
        });
    });
    </script>
@endsection