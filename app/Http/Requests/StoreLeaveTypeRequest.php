<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
            'lv_code' => 'required|string|max:255', 
            'lv_name' => 'required|string|max:255',
            'lv_salary_deduct' => 'required',
            'lv_count_working_days' => 'required',
            'lv_default_count' => 'required|string|max:255', 
            'lv_has_limit' => 'required',
            'lv_allow_attendance_bonus' => 'required',
            'lv_remark' => 'nullable|string',
            'lv_status' => 'required|boolean',
        ];
    }
}
