<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Http;

class StoreEmployeeTrainingHistoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $response = Http::withHeaders([
            'Authorization' => request()->header('Authorization')
        ])->get('http://localhost:8002/api/permission/check/104');
        if($response->status() == 200){
            return true;
        }
        return false;
    }
    public function rules(): array
    {
        return [
            'type' => 'required|string|max:255',
            'program' => 'required|string|max:255',
            'start_date' => 'required|date|before:end_date',
            'end_date' => 'required|date|after:start_date',
            'bond_value' => 'required|numeric|min:0',
            'emp_id' => 'required|integer|exists:employees,id'
        ];
    }
}
