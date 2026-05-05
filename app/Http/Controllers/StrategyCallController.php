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

        // Save Lead to Database
        \App\Models\Lead::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'company' => $validated['company'],
            'message' => $validated['message'],
            'source' => 'Strategy Call Modal',
            'intent_level' => 'High'
        ]);

        try {
            $settings = \App\Models\Setting::pluck('value', 'key')->toArray();
            $notifEmailsRaw = $settings['lead_notification_emails'] ?? 'work.fuelcab@gmail.com';
            $notifEmails = array_map('trim', explode(',', $notifEmailsRaw));

            \Illuminate\Support\Facades\Mail::to($notifEmails)
                ->send(new \App\Mail\StrategyCallRequestMail($validated));
        } catch (\Exception $e) {
            // Log error but don't fail the request since lead is already saved
            \Illuminate\Support\Facades\Log::error('Strategy Call Mail Error: ' . $e->getMessage());
        }

        return response()->json(['success' => true]);
    }
}
