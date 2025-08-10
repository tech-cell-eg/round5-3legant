<?php

namespace App\Http\Controllers\API\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Traits\APIResponseTrait;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use Illuminate\Support\Facades\Password;
use PhpParser\Node\Expr\Throw_;

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

    //Reset password funcitons
    public function sendPasswordResetMessage(Request $request) {
        try {
            $request->validate([
                'email' => 'required|email'
            ]);
            $status = Password::sendResetLink($request->only('email'));
            return $status === Password::RESET_LINK_SENT ? $this->successResponse([], 'Reset link sent to your email', 200)
                : $this->errorResponse([], 'Unable to send reset link', 500);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 'Error', 500);
        }
    }

    public function resetPassword(Request $request) {
        try {
            $request->validate([
                'token'    => 'required',
                'email'    => 'required|email',
                'password' => 'required|min:8|confirmed',
            ]);
            $status = Password::reset(
                $request->only('email', 'password', 'password_confirmation', 'token'),
                function ($user, $password) {
                    $user->password = Hash::make($password);
                    $user->save();
                }
            );
            return $status === Password::PASSWORD_RESET ? $this->successResponse([], 'Password reset successful', 200)
                : $this->errorResponse([], 'Unable to reset password', 500);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 'Error', 500);
        }
    }
}
