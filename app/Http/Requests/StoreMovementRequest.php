<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreMovementRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'items' => 'required|array',
            'items.*.EMP ID' => 'required|string',
            'items.*.Out Date' => 'required|date',
            'items.*.Out Time' => 'required|date_format:H:i',
            'items.*.Out Location' => 'required|string',
            'items.*.In Date' => 'required|date',
            'items.*.In Time' => 'required|date_format:H:i',
            'items.*.In Location' => 'string',
            'items.*.Reason' => 'required|string',
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
