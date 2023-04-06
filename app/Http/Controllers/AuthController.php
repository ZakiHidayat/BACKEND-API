<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $data = $request->only(['email', 'password']);
        $validator = validator($data, [
            'email' => 'required|email',
            'password' => 'required|min:8'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()
            ], 400);
        }

        if (auth()->attempt($data)) {
            $user = auth()->user();
            $token = $user->createToken('TokenBackend')->plainTextToken;
            return response()->json([
                'status' => true,
                'access_token' => $token,
                'data' => $user,
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized'
            ], 401);
        }
    }

    public function register(Request $request)
    {
        $data = $request->only(['name', 'email', 'password']);
        $validator = validator($data, [
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()
            ], 400);
        }
        $data['password'] = Hash::make($data['password']);

        $user = User::create($data);
        $token = $user->createToken('TokenBackend')->plainTextToken;
        return response()->json([
            'status' => true,
            'access_token' => $token,
            'data' => $user,
        ]);
    }
}