<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Auth;

class LaboratoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        if(Auth::user()){
            return true;
        }
        else{
            return false;
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'lab_id' => 'required|numeric|exists:laboratories,id',
            'lab_name' => 'required|min:3',
            'lab_login_email' => 'required|min:3|email',
            'lab_primary_location' => 'required|min:3',
        ];
    }
}
