@foreach($allStudies as $study)
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
                <label for="patient_id">Description</label>
                <textarea class="form-control">{{ $study->description }}</textarea>
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-group">
                <label for="patient_id">&nbsp;</label>
                <div>
                    <button type="button" class="btn btn-warning btn-sm update-existing-study" data-index="{{ $study->id }}">Update</button>
                    <button type="button" class="btn btn-danger btn-sm remove-existing-study" data-index="{{ $study->id }}" data-value="{{ $study->type->name }}">Delete</button>
                </div>
            </div>
        </div>
    </div>
@endforeach