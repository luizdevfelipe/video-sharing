<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;

class VerifyEmailController
{
    public function verifyEmailByHash(EmailVerificationRequest $request, int $id, string $hash): RedirectResponse
    {
        $user = User::findOrFail($id);

        if (! hash_equals(sha1($user->getEmailForVerification()), (string) $hash)) {
            return redirect(config('app.spa.domain') . '/verify-email?status=invalid');
        }

        if ($user->hasVerifiedEmail()) {
            return redirect(config('app.spa.domain'));
        }

        $user->markEmailAsVerified();
        event(new Verified($user));

        return redirect(config('app.spa.domain'));
    }
}
