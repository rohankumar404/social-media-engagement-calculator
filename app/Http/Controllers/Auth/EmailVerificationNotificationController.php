<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class EmailVerificationNotificationController extends Controller
{
    /**
     * Send a new email verification notification.
     */
    public function store(Request $request): RedirectResponse
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->intended(route('dashboard', absolute: false));
        }

        $otp = sprintf("%06d", mt_rand(1, 999999));
        $request->user()->update([
            'otp_code' => $otp,
            'otp_expires_at' => now()->addMinutes(15),
        ]);

        \Illuminate\Support\Facades\Mail::to($request->user()->email)->send(new \App\Mail\SendOtpMail($otp));

        return back()->with('status', 'verification-link-sent');
    }
}
