<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEmployeeCategoryRequest extends FormRequest
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
            'emp_cat_code' => 'required|string|max:255', 
            'emp_cat_name' => 'required|string|max:255',
            'emp_cat_level' => 'required|string|max:150',
            'emp_cat_rank' => 'required|max:15',
            'emp_cat_remark' => 'nullable|string',
            'emp_cat_status' => 'required|boolean',
        ];
    }
}
