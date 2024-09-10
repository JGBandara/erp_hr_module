<?php


    namespace App\Http\Controllers;

    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Auth;
    
    class AuthController extends Controller
    {
        
        // Handle login request
        public function login(Request $request)
        {
            $credentials = $request->only('email', 'password');
    
            if (Auth::attempt($credentials)) {
                // Authentication passed
                return response()->json(['message' => 'Login successful']);
            } else {
                // Authentication failed
                return response()->json(['message' => 'Invalid credentials'], 401);
            }
        }
    
        // Handle logout request
        public function logout()
        {
            Auth::logout();
            return response()->json(['message' => 'Logged out successfully']);
        }
    }
    
