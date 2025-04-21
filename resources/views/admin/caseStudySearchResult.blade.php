<table id="study_table" class="table table-bordered table-hover">
    <thead>
        <tr>
            <th style="width: 2%;">Sl. #</th>
            <th style="width: 6%;">Case Id</th>
            <th style="width: 7%;">Date & Time</th>
            <th style="width: 15%;">Patient Name</th>
            <th style="width: 7%;">Modality</th>
            <th style="width: 5%;">Age Sex</th>
            <th style="width: 6%;">History</th>
            <th style="width: 6%;">Status</th>
            <th>Doctor</th>
            <th style="width: 12%;">Controls</th>
            <th>Centre</th>
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
                        <button class="btn btn-xs bg-gradient-purple" id="view_image" title="View Images"><i class="fas fa-eye"></i></button>
                    @else
                        <button class="btn btn-xs bg-gradient-purple doc_view_image" title="View Images" data-index="{{ $caseStudy->id }}"><i class="fas fa-eye"></i></button>
                    @endif
                    <button class="btn btn-xs bg-gradient-blue view-case-btn" title="View Studies" data-index="{{ $caseStudy->id }}"><i class="fas fa-folder"></i></button>
                    @if(in_array(auth()->user()->roles[0]->id, [1, 5, 6]))
                    <button class="btn btn-xs bg-gradient-orange view-timeline-btn" title="View Timeline" data-index="{{ $caseStudy->id }}"><i class="fas fa-history"></i></button>
                    @endif
                    @if(in_array(auth()->user()->roles[0]->id, [1, 3, 5, 6]) && in_array($caseStudy->study_status_id, [1, 2]))
                    <button class="btn btn-xs bg-gradient-danger delete-case-btn" title="Delete Report" data-index="{{ $caseStudy->id }}"><i class="fas fa-trash"></i></button>
                    @endif
                    @if(in_array(auth()->user()->roles[0]->id, [1, 3, 5, 6]) && $caseStudy->study_status_id == 5)
                    <button class="btn btn-xs bg-gradient-success view-report-btn" title="View Report" data-index="{{ $caseStudy->id }}"><i class="fas fa-file-pdf"></i></button>
                    @endif
                </td>
                <td>{{$caseStudy->laboratory->lab_name}}&nbsp;<i class="fas fa-info-circle me-1 text-info" style="cursor: pointer;" title="Phone Number: {{ $caseStudy->laboratory->lab_phone_number }}"></i></td>
            </tr>
        @endforeach
    </tbody>
</table>
<script>
    var study_table = $('#study_table').DataTable({
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "responsive": true,
        "lengthMenu": [[10, 25, 50, 100, 500, -1], [10, 25, 50, 100, 500, "All"]],
        rowId: function(data) {
            return 'row-' + data.id; // Ensuring a unique ID for each row
        }
    });
    $('#study_table tbody').on('click', '.view-case-btn', function () {
        var tr = $(this).closest('tr');
        var row = study_table.row(tr);
        var case_study_id = $(this).data('index');
        
        if (row.child.isShown()) {
            tr.removeClass('bg-gradient-warning text-black');
            row.child.hide();
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
            $(this).html('<i class="fas fa-folder"></i>');
        } else {
            tr.addClass('bg-gradient-warning text-black');
            $.ajax({
                url: "{{ route('admin.get-all-studies') }}",
                type: "POST",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "case_id": case_study_id
                },
                success: function (response) {
                    row.child(response).show();
                }
            });
            $(this).html('<i class="fas fa-folder-open"></i>');
        }
    });
</script>