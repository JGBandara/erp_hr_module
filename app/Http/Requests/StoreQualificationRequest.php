<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreQualificationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'emp_id'=>'required|int',
            'ol'=>'array',
            'al'=>'array',
            'prof'=>'array',
        ];
    }
}
