<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Jobs\SendWelcomeEmail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class AuthController extends Controller
{
    /**
     * Register a new user.
     */
    public function register(RegisterRequest $request)
    {
        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ]);

        try {
            $user->sendEmailVerificationNotification();
        } catch (\Exception $e) {
            return $this->errorResponse('Failed to send verification email. Please try again.', 500);
        }

        dispatch(new SendWelcomeEmail($user));

        return $this->successResponse($user, 'Registered successfully. Please verify your email.');
    }
    /**
     * Log in a user.
     */
    public function login(LoginRequest $request)
    {
        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return $this->errorResponse('Invalid credentials', 401);
        }

        if (!$user->hasVerifiedEmail()) {
            return $this->errorResponse('Please verify your email first.', 403);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return $this->successResponse([
            'access_token' => $token,
            'token_type'   => 'Bearer',
        ], 'Login successful');
    }

    /**
     * Resend the email verification notification.
     */
    public function resendVerificationEmail(Request $request)
    {
        $user = $request->user();

        if ($user->hasVerifiedEmail()) {
            return $this->errorResponse('Your email is already verified.', 400);
        }

        try {
            $user->sendEmailVerificationNotification();
        } catch (\Exception $e) {
            return $this->errorResponse('Failed to send verification email. Please try again.', 500);
        }

        return $this->successResponse(null, 'Verification email resent successfully.');
    }

    /**
     * Log out the currently authenticated user.
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return $this->successResponse(null, 'Logged out successfully');
    }
}
