<?php

namespace App\Http\Requests;

use App\Services\Util\AuthService;
use Illuminate\Foundation\Http\FormRequest;

class StoreEmployeeHistoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        $authService =  new AuthService();
        return $authService->checkPermission(request(), 'add','human-resource/employee/employment-history/add-new');
    }

    public function rules(): array
    {
        return [
            'emp_id'=>'required|int',
            'data'=>'required|array|min:1',
        ];
    }
}
