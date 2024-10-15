<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDesignationRequest extends FormRequest
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
            'des_code' => 'required|string|max:255', 
            'des_name' => 'required|string|max:255',
            'des_emp_cat_id' => 'required',
            'des_salary_scale_id' => 'nullable|int',
            'des_ot_allowed' => 'required|boolean', 
            'des_early_ot_allowed' => 'required|boolean',
            'des_carder' => 'nullable|string',
            'des_rank' => 'nullable|int',
            'des_dep_id' => 'required',
            'des_duties' => 'nullable|int',
            'div_remark' => 'nullable|string',
            'div_status' => 'required|boolean',
        ];
    }
}