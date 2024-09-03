<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckDepartmentPermission
{
    public function handle($request, Closure $next, $permission)
    {
        $user = Auth::user();

        if (!$user || !$user->hasPermission($permission)) {
            return response()->json(['message' => 'You do not have permission'], 403);
        }

        return $next($request);
    }
}