@foreach ($formFields as $formField)
    @php $value = ''; @endphp
    @foreach ($formFieldsValues as $formFieldsValue)
        @if($formFieldsValue->form_field_id === $formField->form_field_id)
            @php
            $value = $formFieldsValue->value;
            break;
            @endphp
        @endif
    @endforeach
<div class="form-group">
    <label for="{{$formField->FormField->field_alise}}">{{$formField->FormField->field_alise}} @if($formField->FormField->required==1) <em>*</em> @endif</label>
    @if($formField->FormField->element_type == "text"|| $formField->FormField->element_type == "date" || $formField->FormField->element_type == "datetime")
    <input type="text" value="{{$value}}" @if($formField->FormField->required==1) required="required" @endif class="form-control" name="{{$formField->FormField->field_name}}" id="{{$formField->FormField->field_name}}" placeholder="{{$formField->FormField->field_alise}}">
    @elseif($formField->FormField->element_type == "phone")
    <input type="text" value="{{$value}}" @if($formField->FormField->required==1) required="required" @endif class="form-control" name="{{$formField->FormField->field_name}}" id="{{$formField->FormField->field_name}}" placeholder="{{$formField->FormField->field_alise}}">
    @elseif($formField->FormField->element_type == "textarea")
    <textarea class="form-control" rows="3" @if($formField->FormField->required==1) required="required" @endif name="{{$formField->FormField->field_name}}" id="{{$formField->FormField->field_name}}" placeholder="{{$formField->FormField->field_alise}}">{{$value}}</textarea>
    @elseif($formField->FormField->element_type == "select")
    <select class="form-control" name="{{$formField->FormField->field_name}}" id="{{$formField->FormField->field_name}}">
        @foreach($formField->FormField->formFieldOptions as $option)
        <option value="{{$option->option_value}}" @if($option->option_value == $value) selected="selected" @endif>{{$option->option_text}}</option>
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