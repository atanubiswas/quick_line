@foreach($labModalities as $modality)
    <option value="{{$modality->modality->id}}">{{$modality->modality->name}}</option>
@endforeach