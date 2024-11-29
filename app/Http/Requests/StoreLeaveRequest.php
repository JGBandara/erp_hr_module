<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreLeaveRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'request_no'=>'',
            'year' => 'required|digits:4|integer|min:2000|max:' . date('Y'),
            'emp_id' => 'required|integer|exists:hr_emp_personal_details,id',
            'leave_type_id' => 'required|integer|exists:hr_mst_leave_type,id',
            'date_from' => 'required|date|before_or_equal:date_to',
            'date_to' => 'required|date|after_or_equal:date_from',
            'no_of_days' => 'required|numeric|min:0.5',
            'purpose' => 'required|string|max:255',
            'remark' => 'nullable|string|max:255',
            'location_id' => 'required|integer',
            'covering_officer_id' => 'integer|exists:employees,id',

        ];
    }
    public function messages()
    {
        return [
            'year.required' => 'The year field is required.',
            'year.digits' => 'The year must be a 4-digit number.',
            'date_from.before_or_equal' => 'The start date must be before or equal to the end date.',
            'date_to.after_or_equal' => 'The end date must be after or equal to the start date.',
            'no_of_days.min' => 'The number of days must be at least 0.5.',
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
