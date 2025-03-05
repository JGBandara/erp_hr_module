<?php

namespace App\Services\Util;

use App\Exceptions\UnauthorizedException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AuthService
{
    public static function checkPermission(Request $request, string $privilege, string $module){
        if(!$request->headers->has('Authorization')){
            return false;
        }
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
    public static function getAuthUser(Request $request){
        if(!$request->headers->has('Authorization')){
            throw new UnauthorizedException("Unauthorized");
        }
        $response = Http::withHeaders([
            'Authorization' => $request->header('Authorization')
        ])->get('http://localhost:8001/api/user');
        return $response['data'];
    }
}
