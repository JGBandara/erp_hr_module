<?php

namespace App\Http\Requests;

use App\Services\Util\AuthService;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateDesignationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return AuthService::checkPermission(request(),'edit','human-resource/master-data/manage-cardre/add-new');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'id'=>'required|integer',
            'employee_category_id' => 'required|integer|exists:hr_mst_emp_category,id',
            'code' => 'required|string',
            'name' => 'required|string|max:255',
            'salary_scale_id' => 'required|integer',
            'ot_allowed' => 'required|boolean',
            'early_ot_allowed' => 'required|boolean',
            'carder' => 'required|integer|min:1',
            'rank' => 'required|integer|min:1',
            'duties' => 'required|string',
            'remark' => 'nullable|string',
            'active' => 'boolean',
        ];
    }
    public function messages(): array
    {
        return [
            'id.required'=>'The Designation ID required.',
            'employee_category_id.required' => 'The employee category ID is required.',
            'employee_category_id.string' => 'The employee category ID must be a string.',
            'employee_category_id.exists' => 'The selected employee category does not exist.',

            'code.required' => 'The code is required.',
            'code.string' => 'The code must be a string.',
            'code.unique' => 'The code must be unique.',

            'name.required' => 'The name is required.',
            'name.string' => 'The name must be a string.',
            'name.max' => 'The name must not exceed 255 characters.',

            'salary_scale_id.required' => 'The salary scale ID is required.',
            'salary_scale_id.string' => 'The salary scale ID must be a string.',

            'ot_allowed.required' => 'The OT allowed field is required.',
            'ot_allowed.boolean' => 'The OT allowed field must be true or false.',

            'early_ot_allowed.required' => 'The early OT allowed field is required.',
            'early_ot_allowed.boolean' => 'The early OT allowed field must be true or false.',

            'carder.required' => 'The carder field is required.',
            'carder.integer' => 'The carder must be an integer.',
            'carder.min' => 'The carder must be at least 1.',

            'rank.required' => 'The rank field is required.',
            'rank.integer' => 'The rank must be an integer.',
            'rank.min' => 'The rank must be at least 1.',

            'duties.required' => 'The duties field is required.',
            'duties.string' => 'The duties must be a string.',

            'remark.string' => 'The remark must be a string.',

            'active.boolean' => 'The active field must be true or false.',

        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $response = response()->json([
            'status' => 'error',
            'message' => 'Validation errors',
            'errors' => $validator->errors(),
        ], 422);
        throw new HttpResponseException($response);
    }
}
