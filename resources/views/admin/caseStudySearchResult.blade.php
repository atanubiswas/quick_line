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
                <td data-order="{{ $caseStudy->created_at }}">{{ \Carbon\Carbon::parse($caseStudy->created_at)->format('jS M Y, g:i a') }}</td>
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
                <td>{{$caseStudy->modality->name}}</td>
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