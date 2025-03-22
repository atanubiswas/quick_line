<option value="">Select Study Type</option>
@foreach($studyTypes as $studyType)
    <option value="{{$studyType->id}}">{{$studyType->name}}</option>
@endforeach