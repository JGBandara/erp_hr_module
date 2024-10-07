<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEmployeeTrainingHistoryRequest;
use Illuminate\Http\Request;

class EmployeeTrainingHistoryController extends Controller
{
    public function store(StoreEmployeeTrainingHistoryRequest $request){
        return "OK";
    }
}
