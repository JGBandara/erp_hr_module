<?php

namespace App\Traits;

trait ApiResponse
{
    protected function successResponse($data = [], $message = 'Operation successful', $status = 200)
    {
        return response()->json([
            'status' => 'success',
            'message' => $message,
            'data' => $data,
        ], $status);
    }

    protected function errorResponse($message = 'Operation failed', $errors = [], $status = 400)
    {
        return response()->json([
            'status' => 'error',
            'message' => $message,
            'errors' => $errors,
        ], $status);
    }

    protected function notFoundResponse($message = 'Resource not found', $errors = [], $status = 404)
    {
        return response()->json([
            'status' => 'error',
            'message' => $message,
            'errors' => $errors,
        ], $status);
    }

    protected function validationErrorResponse($errors = [], $message = 'Validation errors', $status = 422)
    {
        return response()->json([
            'status' => 'error',
            'message' => $message,
            'errors' => $errors,
        ], $status);
    }
}
