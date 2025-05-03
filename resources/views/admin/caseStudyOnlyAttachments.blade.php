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