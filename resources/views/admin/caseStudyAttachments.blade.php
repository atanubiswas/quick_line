<table class="table table-bordered table-hover" id="attachment_patient_table">
    <thead>
        <tr>
        <th>Label</th>
        <th>Value</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Patient ID</td>
            <td>{{ $caseStudy->patient->patient_id }}</td>
        </tr>
        <tr>
            <td>Patient Name</td>
            <td>{{ $caseStudy->patient->name }}</td>
        </tr>
        <tr>
            <td>Study Name</td>
            <td>
                @foreach($caseStudy->study as $study)
                    {{ $study->type->name }}@if(!$loop->last), @endif
                @endforeach
            </td>
        </tr>
        <tr>
            <td>Centre Name</td>
            <td>{{ $caseStudy->laboratory->lab_name }}</td>
        </tr>
    </tbody>
</table>
@if(in_array($roleId, [1, 3, 5, 6]) && $caseStudy->study_status_id < 3)
    <div style="margin-top: 10px; padding: 8px; border: 1px solid #ccc; border-radius: 6px; display: flex; align-items: center; width: 100%; box-sizing: border-box;">
        <div class="form-group" style="flex-grow: 1; margin-right: 10px;">
        <label class="" for="attachment">Attach Files</label>
        <div class="row">
            <div class="col-md-10">
                <input type="file" id="attachment" multiple name="attachment" class="form-control" style="box-sizing: border-box;">
            </div>
            <div class="col-md-2">
                <button type="button" class="btn btn-primary upload-attachment-btn" style="width: 100%;" data-index="{{  $caseStudy->id }}">Upload</button>
            </div>
        </div>
        </div>
    </div>
@endif
<div class="view_attachments_div" style="margin-top: 10px; padding: 8px; border: 1px solid #ccc; border-radius: 6px; display: flex; align-items: center; width: 100%; box-sizing: border-box;">
    @if($caseStudy->attachments->isEmpty())
    <div class="form-group" style="flex-grow: 1; margin-right: 10px;">
        <label class="" for="attachment">No attachments available.</label>
    </div>
    @else
    <div class="form-group" style="flex-grow: 1; margin-right: 10px;">
        <label style="display: flex;" for="attachment">Attachments</label>
        @foreach($caseStudy->attachments as $attachment)
            <div class="img-thumbnail" style="margin: 5px; display: inline-block; position: relative;">
                @php $extension = pathinfo($attachment->file_name, PATHINFO_EXTENSION); @endphp
                @if($extension != 'pdf')
                    <a href="{{ asset('storage/' . $attachment->file_name) }}" target="_blank"><img src="{{ asset('storage/' . $attachment->file_name) }}" alt="Attachments" style="width: 150px;"></a>
                @else
                    <a href="{{ asset('storage/' . $attachment->file_name) }}" target="_blank"><img src="{{ asset('images/pdf_icon.png')}}" alt="Attachments" style="width: 150px;"></a>
                @endif
            </div>
        @endforeach
    </div>
    @endif
</div>

  <script>
    $(function () {
        $('#attachment_patient_table').DataTable({
            "paging": false,
            "lengthChange": true,
            "searching": false,
            "ordering": false,
            "info": false,
            "autoWidth": false,
            "responsive": true
        });
    });
  </script>
