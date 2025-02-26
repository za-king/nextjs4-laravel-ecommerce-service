<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserRegisterRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Laravel\Sanctum\PersonalAccessToken;
class UserController extends Controller
{
    public function register(UserRegisterRequest $request)
    {
        $data = $request->validated();

        if (User::where("username", $data["username"])->exists()) {
            throw new HttpResponseException(response([
                'errors' => ['username' => 'username already registered']
            ], 422));
        }

        $User = new User($data);
        $User->password = Hash::make($data["password"]);
        $User->save();

        return new UserResource($User);

    }

    public function login(UserLoginRequest $request)
    {
        $data = $request->validated();

        $User = User::where("email", $data["email"])->first();

        if (!$User || !Hash::check($data["password"], $User->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }
        $User->tokens()->delete();

        $accessToken = $User->createToken('access-token', ['*'], now()->addMinutes(60))->plainTextToken;
        $refreshToken = $User->createToken('refresh-token', ['refresh-token'], now()->addDays(7))->plainTextToken;

        return response()->json([
            'access_token' => $accessToken,
            'refresh_token' => $refreshToken,
            'token_type' => 'Bearer'
        ]);
    }

    public function refreshToken(Request $request)
    {
        $request->validate([
            'refresh_token' => 'required'
        ]);

        // Ambil token dari request
        $refreshToken = $request->refresh_token;

        // Cek apakah token valid
        $user = PersonalAccessToken::findToken($refreshToken)?->tokenable;

        if (!$user) {
            return response()->json([
                'message' => 'Invalid refresh token'
            ], 401);
        }

        // Pastikan token memiliki scope 'refresh-token'
        $tokenInstance = PersonalAccessToken::findToken($refreshToken);

        if (!$tokenInstance || !in_array('refresh-token', $tokenInstance->abilities)) {
            return response()->json([
                'message' => 'Invalid refresh token'
            ], 401);
        }

        // Hapus refresh token lama
        $user->tokens()->where('name', 'refresh-token')->delete();

        // Buat access token dan refresh token baru
        $newAccessToken = $user->createToken('access-token', ['*'], now()->addMinutes(15))->plainTextToken;
        $newRefreshToken = $user->createToken('refresh-token', ['refresh-token'], now()->addDays(7))->plainTextToken;

        return response()->json([
            'access_token' => $newAccessToken,
            'refresh_token' => $newRefreshToken,
            'token_type' => 'Bearer'
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        return response()->json(['message' => 'Logged out successfully']);
    }

    public function getAll(Request $request)
    {
        $User = User::all();

        return response()->json(["data" => $User]);
    }
}
