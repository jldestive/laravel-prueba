<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        if (auth()->attempt($request->validated())) {
            /***  @var App/Model/User $user */
            $user = auth()->user();

            $token = $user->createToken('auth-token')->plainTextToken;

            return response()->json([
                'user' => $user,
                'token' => $token
            ], Response::HTTP_OK);
        }

        return response()->json(['message' => 'Unauthorized'], Response::HTTP_UNAUTHORIZED);
    }

    public function register(RegisterRequest $request)
    {
        $user = User::create($request->validated());

        return response()->json(['user' => $user, 'message' => 'User created successfully'], Response::HTTP_CREATED);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        
        return response()->json(['message' => 'Logged out'], Response::HTTP_OK);
    }
}
