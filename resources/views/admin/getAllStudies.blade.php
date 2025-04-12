<table class="child-table">
    <tr>
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
                @elseif(!isset($caseStudy->doctor->name) && $roleId == 3)
                    <tr>
                        <th>Assigned Doctor</th>
                        <th colspan="2">Not Assigned</th>
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
        
    </tr>
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

<script type="text/javascript">
    $(function () {
        $(".assign_doctor").on("change", function () {
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
                } else {
                    
                }
            });
            
        });
    });
</script>