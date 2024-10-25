@foreach ($formFields as $formField)
<div class="form-group">
    <label for="exampleInputEmail1">{{$formField->FormField->field_alise}} @if($formField->FormField->required==1) <em>*</em> @endif @if(!empty($formField->FormField->description)) ({{$formField->FormField->description}}) @endif</label>
    @if($formField->FormField->element_type == "text" || $formField->FormField->element_type == "date" || $formField->FormField->element_type == "datetime")
    <input type="text" @if($formField->FormField->required==1) required="required" @endif class="form-control" name="{{$formField->FormField->field_name}}" id="{{$formField->FormField->field_name}}" placeholder="{{$formField->FormField->field_alise}}">
    @elseif($formField->FormField->element_type == "phone")
    <input type="text" @if($formField->FormField->required==1) required="required" @endif class="form-control" name="{{$formField->FormField->field_name}}" id="{{$formField->FormField->field_name}}" placeholder="{{$formField->FormField->field_alise}}">
    @elseif($formField->FormField->element_type == "textarea")
    <textarea class="form-control" rows="3" @if($formField->FormField->required==1) required="required" @endif name="{{$formField->FormField->field_name}}" id="{{$formField->FormField->field_name}}" placeholder="{{$formField->FormField->field_alise}}"></textarea>
    @elseif($formField->FormField->element_type == "select")
    <select class="form-control" name="{{$formField->FormField->field_name}}" id="{{$formField->FormField->field_name}}">
        @foreach($formField->FormField->formFieldOptions as $option)
        <option value="{{$option->option_value}}" @if($option->is_selected == 1) selected="selected" @endif>{{$option->option_text}}</option>
        @endforeach
    </select>
    @elseif($formField->FormField->element_type == "multiselect")
    <select class="form-control" name="{{$formField->FormField->field_name}}[]" id="{{$formField->FormField->field_name}}" multiple="multiple">
        @foreach($formField->FormField->formFieldOptions as $option)
        <option value="{{$option->option_value}}" @if($option->is_selected == 1) selected="selected" @endif>{{$option->option_text}}</option>
        @endforeach
    </select>
    @endif
</div>
@endforeach