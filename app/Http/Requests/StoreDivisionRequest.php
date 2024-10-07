<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDivisionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        
    
        return [
            'div_code' => 'required|string|max:255', 
            'div_name' => 'required|string|max:255',
            'div_dep_id' => 'required',
            'div_head' => 'required',
            'div_remark' => 'nullable|string',
            'div_status' => 'required|boolean',
        ];
    }
    
}
