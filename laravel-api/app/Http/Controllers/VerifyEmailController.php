<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\RedirectResponse;

class VerifyEmailController
{
    public function verifyEmailByHash(int $id, string $hash): RedirectResponse
    {
        $user = User::find($id);

        if (!$user) {
            return redirect('http://' . config('app.spa.domain') . '/verify-email?status=not-found');
        }

        if (! hash_equals(sha1($user->getEmailForVerification()), (string) $hash)) {
            return redirect('http://' . config('app.spa.domain') . '/verify-email?status=invalid');
        }

        if (!$user->hasVerifiedEmail()) {
            $user->markEmailAsVerified();
            event(new Verified($user));
        }

        return redirect('http://' . config('app.spa.domain') . '/verify-email?status=success');
    }
}
