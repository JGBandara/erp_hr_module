<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class CheckDepartmentPermission
{
    public function handle($request, Closure $next, $permission)
    {
        // $user  = Http::withHeaders([
        //     'Authorization' => $request->header('Authorization')
        // ])->get('http://localhost:8001/api/user');

        // if (!$user) {
            // return $user;
        // }

        // Assuming the permission check service can be accessed via the session-based user
        
        $response = Http::withHeaders([
            'Authorization' => $request->header('Authorization')
        ])->get('http://localhost:8002/api/permission/check', [
            'user_id' => $user->id,
            'permission' => $permission,
        ]);
        // $response = Http::withHeaders([
        //     'Authorization' => $request->header('Authorization')
        // ])->get(config('services.permission_service.url').'permission/check', [
        //     'user_id' => $user->id,
        //     'permission' => $permission,
        // ]);
        if ($response->status() !== 200 || !$response->json()['has_permission']) {
            return response()->json(['message' => 'You do not have permission'], 403);
        }

        return $next($request);
    }
}