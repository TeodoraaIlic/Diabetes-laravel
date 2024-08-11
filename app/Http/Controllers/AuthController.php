<?php

namespace App\Http\Controllers;

use App\Mail\ResetPassword;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    public function register(Request $request): JsonResponse
    {
        $validateData = $request->validate([
            'first_name' => 'required|string|max:32',
            'last_name' => 'required|string|max:32',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'type' => 'required|string|in:standard,premium,admin',
            'height' => 'integer|min:120|max:255',
            'weight' => 'integer|min:40|max:250',
            'activity_level' => 'required|string|in:high,medium,low',
            'birthday_date' => 'required|date',
        ]);

        $password = Hash::make($request->password);

        $validateData['password'] = $password;
        $user = User::create($validateData);

        $token = $user->createToken('auth_token')->plainTextToken;

        $user->assignRole($validateData['type']);

        return response()->json(['access_token' => $token, 'token_type' => 'Bearer']);
    }

    public function login(Request $request): JsonResponse
    {
        if (! Auth::attempt($request->only('email', 'password'))) {
            return response()->json(['message' => 'Invalid login details'], 401);
        }

        $user = User::where('email', $request['email'])->firstOrFail();
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json(['access_token' => $token, 'token_type' => 'Bearer']);
    }

    public function logout(Request $request): JsonResponse
    {
        $request->user()->tokens()->delete();

        return response()->json(['message' => 'Successfully logged out']);
    }

    public function resetPasswordMail(): JsonResponse
    {
        $validateData = request()->only('email');
        $user = User::where('email', $validateData['email'])->first();
        if ($user == null) {
            return response()->json('User not registered', 404);
        }
        $code = $this->generateRandomString();
        $link = 'testlink';
        Mail::to($validateData['email'])->send(new ResetPassword($link, $code,now()->addMinutes(60)));
        $user->update([
            'reset_password_code' => $code,
            'code_expires_at' => now()->addMinutes(60),
        ]);

        return response()->json('Check your email please', 200);
    }

    public function resetPassword(Request $request)
    {
        // Validate the input
        $validateData = $request->validate([
            'email' => 'required|email|exists:users,email',
            'reset_password_code' => 'required|string|size:6|exists:users,reset_password_code',
            'password' => 'required|string|min:8',
        ]);

        // Retrieve the user by email and reset code
        $user = User::where('email', $validateData['email'])
            ->where('reset_password_code', $validateData['reset_password_code'])
            ->where('code_expires_at', '>', now()) // Check if the code hasn't expired
            ->first();

        if (! $user) {
            return response()->json(['message' => 'Invalid or expired reset code.'], 400);
        }

        // Update the user's password and clear the reset code
        $user->update([
            'password' => Hash::make($validateData['password']),
            'reset_password_code' => null,
            'code_expires' => null,
        ]);

        return response()->json('Password successfully reset.');
    }

    private function generateRandomString($length = 6): string
    {
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }

        return $randomString;
    }
}
