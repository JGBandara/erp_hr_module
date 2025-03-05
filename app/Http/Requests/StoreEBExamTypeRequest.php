<?php

namespace App\Http\Requests;

use App\Services\Util\AuthService;
use Illuminate\Foundation\Http\FormRequest;

class StoreEBExamTypeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return AuthService::checkPermission(request(),'add','');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            //
        ];
    }
}
