<option value="" selected="selected">Select Study</option>
@foreach($studyTypes as $studyType)
<option value="{{ $studyType->id }}">{{ $studyType->name }}</option>
@endforeach