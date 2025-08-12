<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EmailVerifyController extends Controller {
    public function verify($id, $hash) {
        $user = User::find($id);
        if (! hash_equals((string) $user->getKey(), (string) $id)) {
            abort(403);
        }
        if (! hash_equals(sha1($user->getEmailForVerification()), (string) $hash)) {
            abort(403);
        }
        if ($user->email_verified_at) {
            return view('messages.alreadyVerified');
        }
        $user->markEmailAsVerified();
        return view('messages.verified');
    }
}
