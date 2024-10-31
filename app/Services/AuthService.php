<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AuthService
{
    public function checkPermission(Request $request, string $privilege, string $module){
        $header = $request->headers->all()['authorization'][0];
        $response = Http::withHeaders([
            'Authorization' => $header,
        ])->post('http://localhost:8002/api/permission/check/path',[
            'path'=>$module,
            'privilege'=>$privilege,
        ]);

        if($response->status() == 200){
            return true;
        }

        return false;
    }
}
