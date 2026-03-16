<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

//Register function
    public function register(Request $request)
    {

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8|confirmed'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        $token = $user->createToken('api-token')->plainTextToken;

        return response()->json([
            'user' => $user,
            'token' => $token
        ], 201);
    }

//Login function
public function login(Request $request){

    $credentials = $request->only('email','password');

    if(!Auth::attempt($credentials)){
        return response()->json([
            'message'=>'Invalid credentials'
        ],401);
    }

    $user = Auth::user();

    $token = $user->createToken('api-token')->plainTextToken;

    return response()->json([
        'token'=>$token
    ]);
}

//Logout
public function logout(Request $request)
{
    $request->user()->currentAccessToken()->delete();

    return response()->noContent();
}

//




}


