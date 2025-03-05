<?php

namespace App\Http\Requests;

use App\Services\Util\AuthService;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateEducationalQualificationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return AuthService::checkPermission(request(),'edit','human-resource/master-data/education-qualifications/manage');
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
            'name' => 'required|string|max:255',
            'remark' => 'nullable|string',
            'active' => 'boolean',
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
