<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;

class VerifyEmailController extends Controller
{
    /**
     * Mark the authenticated user's email address as verified.
     */
    public function __invoke(EmailVerificationRequest $request): RedirectResponse
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->intended(route('dashboard', absolute: false).'?verified=1');
        }

        if ($request->user()->markEmailAsVerified()) {
            event(new Verified($request->user()));
        }

        return redirect()->intended(route('dashboard', absolute: false).'?verified=1');
    }

    /**
     * Mark the authenticated user's email address as verified using OTP.
     */
    public function otp(\Illuminate\Http\Request $request): RedirectResponse
    {
        $request->validate(['otp' => 'required|string|size:6']);

        $user = $request->user();

        if ($user->hasVerifiedEmail()) {
            return redirect()->intended(route('dashboard', absolute: false).'?verified=1');
        }

        if ($user->otp_code === $request->otp && $user->otp_expires_at && now()->lessThanOrEqualTo($user->otp_expires_at)) {
            if ($user->markEmailAsVerified()) {
                event(new Verified($user));
                $user->update(['otp_code' => null, 'otp_expires_at' => null]);
            }

            return redirect()->intended(route('dashboard', absolute: false).'?verified=1');
        }

        return back()->withErrors(['otp' => 'The provided OTP code is invalid or has expired.']);
    }
}
