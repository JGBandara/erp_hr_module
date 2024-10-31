<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;

class DepartmentNotFoundException extends Exception
{
    public function __construct(string $message = "", int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    public function render($request): JsonResponse
    {
        return response()->json([
            'error' => $this->getMessage(),
        ], $this->code);
    }
}
