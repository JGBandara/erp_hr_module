<?php

namespace App\Http\Requests;

use App\Services\Util\AuthService;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreDivisionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return AuthService::checkPermission(request(),'add','human-resource/master-data/division/add-new');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'code' => 'required|string|unique:hr_mst_division,code',
            'name' => 'required|string|max:255',
            'department_id' => 'required|integer|exists:hr_mst_department,id',
            'head_of_department_id' => 'required|integer|exists:hr_emp_personal_details,id',
            'remark' => 'nullable|string',
            'active' => 'boolean',
        ];
    }
    public function messages(): array
    {
        return [
            'code.required' => 'The code is required.',
            'code.string' => 'The code must be a string.',
            'code.unique' => 'The code must be unique.',

            'name.required' => 'The name is required.',
            'name.string' => 'The name must be a string.',
            'name.max' => 'The name must not exceed 255 characters.',

            'department_id.required' => 'The department ID is required.',
            'department_id.integer' => 'The department ID must be an integer.',
            'department_id.exists' => 'The selected department does not exist.',

            'head_of_department_id.required' => 'The head of department ID is required.',
            'head_of_department_id.integer' => 'The head of department ID must be an integer.',
            'head_of_department_id.exists' => 'The selected head of department does not exist.',

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
