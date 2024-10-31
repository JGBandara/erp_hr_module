<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class StorePersonalDetailsRequest extends FormRequest
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
            'personal_file_no' => 'required|string|max:255',
            'serial_no' => 'required|string|max:255',
            'title' => 'required|string|max:100',
            'initials' => 'required|string|max:100',
            'surname' => 'required|string|max:100',
            'full_name' => 'required|string|max:255',
            'nic' => 'required|string|max:20',
            'dob' => 'required|date',
            'civil_status' => 'required|in:single,married',
            'gender' => 'required|in:male,female',
            'religion' => 'required|string|max:100',
            'permanent_address' => 'required|string|max:255',
            'mobile' => 'required|string|max:15',
            'personal_email' => 'required|email|max:255',
            'current_address' => 'required|string|max:255',
            'residence_phone_number' => 'required|string|max:15',
            'emerg_phone_and_cont_num' => 'string|max:15',
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
