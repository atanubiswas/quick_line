<table class="child-table">
        @if(isset($study['error']))
                <th>Error</th>
            @else
                @if(!isset($caseStudy->doctor->name) && $roleId != 3)
                    <tr>
                        <th>Assign Doctor</th>
                        <th colspan="2">
                            <select name="doctor_id" date-case-id="{{ $caseId }}" class="form-control select2 assign_doctor">
                            <option value="">Select Doctor</option>
                                @if($assignedDoctor !== null)
                                    <optgroup label="Preferred Doctor">
                                        <option value="{{ $assignedDoctor->id }}">{{ $assignedDoctor->name }}</option>
                                    </optgroup>
                                @endif
                                
                                <optgroup label="Faverite Doctors">
                                @if($faveriteDoctors !== null)
                                    @foreach($faveriteDoctors as $doctor)
                                        <option value="{{ $doctor->id }}">{{ $doctor->name }}</option>
                                    @endforeach
                                @endif
                                </optgroup>
                                <optgroup label="All Doctors">
                                @foreach ($doctors as $doctor)
                                    <option value="{{ $doctor->id }}">{{ $doctor->name }}</option>
                                @endforeach
                                </optgroup>
                            </select>
                        </th>
                    </tr>
                    @elseif(isset($caseStudy->doctor->name) && $caseStudy->study_status_id <= 2 && in_array($roleId, [1, 5, 6]))
                    <tr>
                        <th>Update Doctor</th>
                        <th colspan="2">
                            <select name="doctor_id" date-case-id="{{ $caseId }}" class="form-control select2 assign_doctor">
                            <option value="">Select Doctor</option>
                                @if($assignedDoctor !== null)
                                    <optgroup label="Preferred Doctor">
                                        <option value="{{ $assignedDoctor->id }}">{{ $assignedDoctor->name }}</option>
                                    </optgroup>
                                @endif
                                
                                <optgroup label="Faverite Doctors">
                                @if($faveriteDoctors !== null)
                                    @foreach($faveriteDoctors as $doctor)
                                        <option value="{{ $doctor->id }}">{{ $doctor->name }}</option>
                                    @endforeach
                                @endif
                                </optgroup>
                                <optgroup label="All Doctors">
                                @foreach ($doctors as $doctor)
                                    <option value="{{ $doctor->id }}" @if($caseStudy->doctor->id == $doctor->id) selected="selected" @endif>{{ $doctor->name }}</option>
                                @endforeach
                                </optgroup>
                            </select>
                        </th>
                    </tr>
                    @elseif(!isset($caseStudy->doctor->name) && $roleId == 3)
                    <tr>
                        <th>Assigned Doctor</th>
                        <th colspan="2">Not Assigned</th>
                    </tr>
                    @elseif(isset($caseStudy->doctor->name) && $caseStudy->study_status_id == 3 && in_array($roleId, [1, 5, 6]))
                    <tr>
                        <th>Assigned Doctor</th>
                        <th colspan="2">{{ $caseStudy->doctor->name }}</th>
                    </tr>
                    <tr>
                        <th>Change Status</th>
                        <td colspan="2">
                            <select name="study_status_id" class="form-control select2 study_status_id" id="study_status_id_{{ $caseId }}" data-case-id="{{ $caseId }}">
                                <option value="">Select Status</option>
                                <option value="2">Second Openion</option>
                                <option value="4">Re-Work</option>
                                <option value="5">Finished</option>
                            </select>
                            <select name="second_opnion_doctor_id" id="second_opnion_assign_doctor_{{ $caseId }}" data-case-id="{{ $caseId }}" class="form-control select2" style="display: none; margin-top: 10px;">
                                <option selected value="">Select 2nd Opnion Doctor</option>
                                @if($assignedDoctor !== null)
                                    <optgroup label="Preferred Doctor">
                                        <option value="{{ $assignedDoctor->id }}" @if($caseStudy->doctor->id == $assignedDoctor->id) disabled @endif>{{ $assignedDoctor->name }}</option>
                                    </optgroup>
                                @endif
                                
                                <optgroup label="Faverite Doctors">
                                @if($faveriteDoctors !== null)
                                    @foreach($faveriteDoctors as $doctor)
                                        <option value="{{ $doctor->id }}" @if($caseStudy->doctor->id == $doctor->id) disabled @endif>{{ $doctor->name }}</option>
                                    @endforeach
                                @endif
                                </optgroup>
                                <optgroup label="All Doctors">
                                @foreach ($doctors as $doctor)
                                    <option value="{{ $doctor->id }}" @if($caseStudy->doctor->id == $doctor->id) disabled @endif>{{ $doctor->name }}</option>
                                @endforeach
                                </optgroup>
                            </select>
                            <button type="button" class="btn bg-gradient-orange btn-sm change_status_btn" style="margin-top: 10px; float: right;" data-case-id="{{ $caseId }}">Update Status</button>
                        </td>
                    </tr>
                    @else
                    <tr>
                        <th>Assigned Doctor</th>
                        <th colspan="2">{{ $caseStudy->doctor->name }}</th>
                    </tr>
                    @endif
                <th>Modality</th>
                <th>Study</th>
                <td>Description</td>
            @endif
    @if(isset($study['error']))
        <tr>
            <td>{{ $study['error'] }}</td>
        </tr>
    @else
        @foreach($allStudies as $study)
            <tr>
                <td>{{ $study->type->modality->name }}</td>
                <td>{{ $study->type->name }}</td>
                <td>{{ $study->description }}</td>
            </tr>
        @endforeach
    @endif
</table>