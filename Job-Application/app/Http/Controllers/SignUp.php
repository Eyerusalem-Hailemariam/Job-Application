<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class SignUp extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|confirmed',
            'role' => 'required|string|in:applicant,company', 
        ]);

       
        $password = $request->password;
        if (
            strlen($password) < 8 ||
            !preg_match('/[A-Z]/', $password) ||     
            !preg_match('/[a-z]/', $password) ||       
            !preg_match('/[0-9]/', $password) ||     
            !preg_match('/[\W_]/', $password)        
        ) {
            return response()->json([
                'message' => 'Password must be at least 8 characters long and include uppercase, lowercase, number, and special character.'
            ], 400);
        }
        
       
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($password),
            'role' => $request->role,
        ]);

        if (!$user) {
            return response()->json(['message' => 'User registration failed'], 500);
        }


        return response()->json([
            'message' => 'User registered successfully',
            'user' => $user
        ], 201);
    }
}
