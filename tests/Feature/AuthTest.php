<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\PasswordOtp;
use App\Mail\PasswordOTPMail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthTest extends TestCase {
    use RefreshDatabase;
    public function test_user_can_register(): void {
        $response = $this->postJson('api/register', [
            'username' => 'Ahmed',
            'email' => 'ahmed@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);
        $response->assertStatus(201)
            ->assertJson([
                'success' => true,
                'message' => 'User Registerd Successfully please verify your email to continue',
            ]);
        $this->assertDatabaseHas('users', ['email' => 'ahmed@example.com']);
    }
    public function test_user_can_login(): void {
        $user = User::factory()->create([
            'username' => 'Ahmed',
            'password' => Hash::make('password'),
        ]);
        $response = $this->postJson('api/login', [
            'username' => 'Ahmed',
            'password' => 'password',
        ]);
        $response->assertStatus(200)->assertJson([
            'success' => true,
            'message' => 'Login Successful',
        ])->assertJsonStructure(['data' => ['user', 'token']]);
    }
    public function test_user_forget_password_email_sent(): void {
        Mail::fake();
        $user = User::factory()->create(['email' => 'ahmed@example.com']);
        $response = $this->postJson('api/forget-password', [
            'email' => 'ahmed@example.com',
        ]);
        $response->assertStatus(201)->assertJson([
            'success' => true,
            'message' => 'OTP send to your email',
        ]);
        Mail::assertSent(PasswordOTPMail::class);
        $this->assertDatabaseHas('password_otps', ['email' => 'ahmed@example.com']);
    }
    public function test_user_can_reset_password(): void {
        User::factory()->create(['email' => 'ahmed@example.com']);
        PasswordOtp::create([
            'email' => 'ahmed@example.com',
            'otp' => '1111',
            'expires_at' => now()->addMinute(10),
        ]);
        $response = $this->postJson('api/reset-password', [
            'email' => 'ahmed@example.com',
            'otp' => '1111',
            'password' => 'newpassword',
            'password_confirmation' => 'newpassword'
        ]);
        $response->assertStatus(200)->assertJson([
            'success' => true,
            'message' => 'Password reset successfully',
        ]);
    }
}
