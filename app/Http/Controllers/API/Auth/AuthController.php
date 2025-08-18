<?php

namespace App\Http\Controllers\API\Auth;

use Carbon\Carbon;
use App\Models\User;
use App\Models\PasswordOTP;
use Illuminate\Http\Request;
use App\Mail\PasswordOTPMail;
use PhpParser\Node\Expr\Throw_;
use App\Traits\APIResponseTrait;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Auth\Events\Registered;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Support\Facades\Password;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\PasswordOtp as ModelsPasswordOtp;

class AuthController extends Controller {

    use APIResponseTrait;

    public function register(RegisterRequest $request) {
        try {
            $user = User::create([
                'username' => $request->username,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);
            $token = $user->createToken('auth')->plainTextToken;
            $data = [
                'user' => $user,
                'token' => $token,
            ];
            event(new Registered($user));
            return $this->successResponse($data, 'User Registerd Successfully please verify your email to continue', 200);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 'Error', 500);
        }
    }
    public function login(LoginRequest $request) {
        try {
            $credentials = $request->only('username', 'password');
            $loginType = filter_var($request->username, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
            if (!Auth::attempt([$loginType => $credentials['username'], 'password' => $credentials['password']])) {
                return $this->errorResponse([], 'Incorrect email/username or password', 401);
            }
            $user = Auth::user();
            $token = $user->createToken('auth')->plainTextToken;
            $data = [
                'user' => $user,
                'token' => $token,
            ];
            return $this->successResponse($data, "Login Successful", 201);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 'Error', 500);
        }
    }
    public function logout(Request $request) {
        try {
            $request->user()->tokens()->delete();
            return $this->successResponse([], 'You have successfully logged out', 200);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 'Error', 500);
        }
    }

    public function sendPasswordResetOTP(Request $request) {
        try {
            $request->validate([
                'email' => 'required|email|exists:users,email'
            ]);
            $email = $request->email;
            $otp = str_pad(rand(0, 9999), 4, '0', STR_PAD_LEFT);
            PasswordOtp::create([
                'otp' => $otp,
                'email' => $email,
                'expires_at' => now()->addMinutes(10),
            ]);
            Mail::to($email)->send(new PasswordOTPMail($otp));
            return $this->successResponse([], 'OTP send to your email', 201);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 'Error', 500);
        }
    }

    public function resetPassword(Request $request) {
        try {
            $request->validate([
                'email'    => 'required|email|exists:users,email',
                'otp' => 'required|string',
                'password' => 'required|confirmed|string|min:8'
            ]);
            $OTP = ModelsPasswordOtp::where('email', $request->email)->where('otp', $request->otp)->where('expires_at', '>', now())->first();
            if (!$OTP) {
                return $this->errorResponse([], 'Invalid OTP', 400);
            }
            $user = User::where('email', $request->email)->first();
            if (!$user) {
                return $this->errorResponse([], 'User not found', 404);
            }
            $user->update([
                'password' => Hash::make($request->password),
            ]);
            $OTP->update([
                'is_used' => true
            ]);
            return $this->successResponse([], 'Password reset successfully');
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 'Error', 500);
        }
    }
}
