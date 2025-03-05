<?php

namespace App\Http\Requests;

use App\Services\Util\AuthService;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateDepartmentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return AuthService::checkPermission(request(), 'edit', 'human-resource/master-data/department/add-new');
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
            'code' => 'required|string',
            'name' => 'required|string|max:255',
            'remark' => 'nullable|string',
            'active' => 'required|boolean',
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
    public function messages(): array
    {
        return [
            'id.required' => 'The ID is required.',
            'id.integer' => 'The ID must be an integer.',

            'code.required' => 'The code is required.',
            'code.string' => 'The code must be a string.',

            'name.required' => 'The name is required.',
            'name.string' => 'The name must be a string.',
            'name.max' => 'The name must not exceed 255 characters.',

            'remark.string' => 'The remark must be a string.',

            'active.required' => 'The active field is required.',
            'active.boolean' => 'The active field must be true or false.',
        ];
    }

}
