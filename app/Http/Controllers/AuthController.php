<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\PersonalAccessToken;

class AuthController extends Controller
{
    // LOGIN
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        $user = User::where(
            'email',
            $credentials['email']
        )->first();

        if (
            !$user ||
            !Hash::check(
                $credentials['password'],
                $user->password
            )
        ) {
            return response()->json([
                'message' => 'Email atau password salah.',
            ], 401);
        }

        // Admin mendapat izin baca dan tulis.
        // Anggota hanya mendapat izin baca.
        $abilities = $user->is_admin
            ? ['books:read', 'books:write']
            : ['books:read'];

        // Token berlaku selama 8 jam.
        $token = $user->createToken(
            'pustaka-literasi',
            $abilities,
            now()->addHours(8)
        );

        return response()->json([
            'message' => 'Login berhasil.',

            'access_token' => $token->plainTextToken,

            'token_type' => 'Bearer',

            'expires_at' => $token->accessToken
                ->expires_at?->toISOString(),

            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'is_admin' => $user->is_admin,
            ],

            'abilities' => $abilities,
        ], 200);
    }

    // MENAMPILKAN IDENTITAS PENGGUNA
    public function me(Request $request)
    {
        $user = $request->user();
        $token = $user->currentAccessToken();

        return response()->json([
            'message' => 'Identitas pengguna berhasil diambil.',

            'data' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'is_admin' => $user->is_admin,
            ],

            'abilities' => $token->abilities ?? [],

            'expires_at' => $token instanceof PersonalAccessToken
                ? $token->expires_at?->toISOString()
                : null,
        ], 200);
    }

    // LOGOUT
    public function logout(Request $request)
    {
        $token = $request->user()->currentAccessToken();

        if ($token instanceof PersonalAccessToken) {
            $token->delete();
        }

        return response()->json([
            'message' => 'Logout berhasil. Token telah dicabut.',
        ], 200);
    }
}