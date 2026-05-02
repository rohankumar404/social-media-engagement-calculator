<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StrategyCallController extends Controller
{
    public function submit(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'company' => 'nullable|string|max:255',
            'message' => 'nullable|string',
        ]);

        $settings = \App\Models\Setting::pluck('value', 'key')->toArray();
        $notifEmailsRaw = $settings['lead_notification_emails'] ?? 'work.fuelcab@gmail.com';
        $notifEmails = array_map('trim', explode(',', $notifEmailsRaw));

        \Illuminate\Support\Facades\Mail::to($notifEmails)
            ->send(new \App\Mail\StrategyCallRequestMail($validated));

        return response()->json(['success' => true]);
    }
}
