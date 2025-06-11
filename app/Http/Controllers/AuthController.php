<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{


    public function getUsers()
    {
        return "hello";
    }

    public function login(Request $request)
    {
       
        // Validate the request
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        // Attempt to authenticate the user
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = User::where('email',$request->email)->first();

            
            return response()->json([
                'message' => 'Login successful',
                'user' => $user,
                'token' => $user->createToken($request->email)->plainTextToken,
            ]);
        }
// return resource file php artisan make:resource UserShowResourse
        // Return error if authentication fails
        return response()->json(['message' => 'Invalid credentials'], 401);
    }

    public function logout(Request $request)
    {
        // Revoke the user's token
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Logged out successfully']);
    }
}
    