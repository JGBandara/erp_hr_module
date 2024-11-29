<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreLeaveTypeRequest extends FormRequest
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
            'lv_code'=>'required|string',
            'lv_name' => 'required|string|max:255',
            'lv_salary_deduct' => 'required',
            'lv_count_working_days' => 'required',
            'lv_default_count' => 'required|string|max:255',
            'lv_has_limit' => 'required',
            'lv_allow_attendance_bonus' => 'required',
            'lv_remarks' => 'nullable|string',
            'lv_status' => 'required|boolean',
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
