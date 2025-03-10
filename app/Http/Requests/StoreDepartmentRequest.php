<?php

namespace App\Http\Requests;

use App\Services\Util\AuthService;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreDepartmentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return AuthService::checkPermission(request(),'add','human-resource/master-data/department/add-new');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'code' => 'required|string|unique:hr_mst_department,code',
            'name' => 'required|string|max:255',
            'remark' => 'nullable|string',
            'active' => 'boolean',
            'is_deleted' => 'boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'code.required' => 'The department code is required.',
            'code.string' => 'The department code must be a string.',
            'code.unique' => 'The department code must be unique.',

            'name.required' => 'The department name is required.',
            'name.string' => 'The department name must be a string.',
            'name.max' => 'The department name must not exceed 255 characters.',

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
