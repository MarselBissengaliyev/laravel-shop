<?php

namespace App\Http\Controllers;

use App\Http\Requests\SignInRequest;
use App\Http\Requests\SignUpRequest;
use App\Models\User;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    //
    public function SignUp(SignUpRequest $request)
    {
        try {
            $validated = $request->validated();

            $user = User::create([
                'user_name' => $validated['user_name'],
                'password' => Hash::make($validated['password']),
                'role' => $validated['role'],
            ]);

            $token = $user->createToken($request->userAgent())->plainTextToken;

            return response()->json([
                'status' => 'success',
                'data' => [
                    'token' => $token
                ],
                'message' => 'user created successfully'
            ], 201);
        } catch (\Throwable $th) {
            throw new HttpResponseException(response()->json([
                'status' => 'failed',
                'message' => $th->getMessage(),
            ], 500));
        }
    }

    public function SignIn(SignInRequest $request)
    {
        try {
            $validated = $request->validated();

            $user = User::query()->where('user_name', $validated['user_name'])->first();

            if ($user == null) {
                return response()->json([
                    'status' => 'failed',
                    'message' => 'user has not been found'
                ], 404);
            }

            $passwordIsValid = Hash::check($validated['password'], $user->password);
            if (!$passwordIsValid) {
                return response()->json([
                    'status' => 'failed',
                    'message' => 'not correct password'
                ], 400 );
            }

            $token = $user->createToken($request->userAgent())->plainTextToken;

            return response()->json([
                'status' => 'success',
                'data' => [
                    'token' => $token
                ],
                'message' => 'user logined successfully'
            ], 200);
        } catch (\Throwable $th) {
            throw new HttpResponseException(response()->json([
                'status' => 'failed',
                'message' => $th->getMessage(),
            ], 500));
        }
    }

    public function Logout(Request $request)
    {
        try {
            $request->user()->currentAccessToken()->delete();

            return response()->json('', 204);
        } catch (\Throwable $th) {
            throw new HttpResponseException(response()->json([
                'status' => 'failed',
                'message' => $th->getMessage(),
            ], 500));
        }
    }
}
