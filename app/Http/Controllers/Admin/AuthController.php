<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\API\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\Penumpang;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    public function register(Request $request, ResponseFormatter $responseFormatter)
    {
        $request->validate([
            'nama' => ['required'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => [Password::min(8)
                ->mixedCase()
                ->numbers()
                ->uncompromised()],
        ]);

        $file = 'images/Profile/default-profile.jpg';

        $user = User::create([
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 1,
            'photo' => $file,
        ]);

        Penumpang::create([
            'user_id' => $user->id,
            'nama' => $request->nama,
        ]);

        try {
            return $responseFormatter->success($user, 'Registrasi Akun Berhasil!', 201);
        } catch (\Throwable $th) {
            return $responseFormatter->error($th, 'Error!', 400);
        }
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ]);

        $user = User::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Invalid credentials'
            ], 401);
        }

        $token = $user->createToken('auth_token')->plainTextToken;
        return response()->json([
            'token' => 'Bearer ' . $token,
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json([
            'message' => 'Logged out',
        ]);
    }
}
