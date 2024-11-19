<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserRegisterRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Auth;


class AuthController extends Controller
{
    public function register(UserRegisterRequest $request): JsonResponse
    {
        $data = $request->validated();

        if (User::query()->where('email', $data['email'])->count() == 1) {
            throw new HttpResponseException(response()->json([
                'errors' => 'Email already registered',
            ], 400));
        }

        $user = new User($data);
        $user->password = Hash::make($data['password']);
        $user->save();

        $token = JWTAuth::fromUser($user);

        return response()->json([
            'user' => new UserResource($user),
            'token' => $token,
        ], 201);
    }
    public function login(UserLoginRequest $request): JsonResponse
    {
        $data = $request->validated();

        if (!$token = JWTAuth::attempt($data)) {
            throw new HttpResponseException(response()->json([
                'errors' => 'Email atau Password kamu salah',
            ], 401));
        }

        return response()->json([
            'token' => $token,
            'user' => new UserResource(Auth::user()),
        ]);
    }
}
