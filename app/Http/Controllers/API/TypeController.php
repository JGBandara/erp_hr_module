<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Type;
use App\Traits\ApiResponse;

class TypeController extends Controller
{
    use ApiResponse;
    public function getAll(){
        return $this->successResponse(Type::all());
    }
}
