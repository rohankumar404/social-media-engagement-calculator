<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setting;
use App\Models\Currency;
use Illuminate\Support\Facades\Cache;

class AdminSettingController extends Controller
{
    public function index()
    {
        $settingsRaw = Setting::all();
        $settings = [];
        
        foreach($settingsRaw as $s) {
            $settings[$s->key] = $s->value;
        }

        // Establish core defaults visually if empty
        $defaults = [
            'tool_title' => 'Social Media Engagement Calculator',
            'cta_text' => 'Get Started',
            'primary_color' => '#85f43a',
            'dark_mode_bg' => '#272727',
            'guest_limit' => 2,
            'auth_limit' => 3,
            'er_viral' => 6,
            'er_high' => 3,
            'white_label_active' => '0',
            'custom_client_title' => 'Social Media Engagement Calculator',
            'custom_logo_path' => '',
            'support_email' => 'support@mapsily.com',
            'lead_notification_emails' => 'work.fuelcab@gmail.com'
        ];
        
        foreach($defaults as $key => $val) {
            if(!isset($settings[$key])) {
                $settings[$key] = $val;
            }
        }
        
        $currencies = Currency::all();
        
        return view('admin.settings', compact('settings', 'currencies'));
    }

    public function update(Request $request)
    {
        $data = $request->except(['_token', 'custom_logo']);
        
        // Handle boolean toggle for white label
        $data['white_label_active'] = $request->has('white_label_active') ? '1' : '0';
        
        // Handle Logo Upload safely
        if ($request->hasFile('custom_logo')) {
            $path = $request->file('custom_logo')->store('logos', 'public');
            $data['custom_logo_path'] = $path;
        }
        
        foreach($data as $key => $val) {
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $val]
            );
        }

        // Clear cache
        Cache::forget('active_currencies');
        Cache::forget('system_settings');
        
        return redirect()->route('admin.settings')->with('success', 'Tool settings & branding successfully applied globally.');
    }

    public function addCurrency(Request $request)
    {
        $request->validate([
            'code' => 'required|string|unique:currencies,code|max:3',
            'symbol' => 'required|string|max:10',
            'exchange_rate' => 'required|numeric|min:0.0001'
        ]);

        Currency::create($request->only(['code', 'symbol', 'exchange_rate']));

        // Clear cache
        Cache::forget('active_currencies');

        return redirect()->route('admin.settings')->with('success', 'Currency added successfully.');
    }

    public function deleteCurrency($id)
    {
        $currency = Currency::findOrFail($id);
        $defaultCode = Setting::where('key', 'system_default_currency')->value('value') ?? 'USD';

        if ($currency->code === $defaultCode) {
            return redirect()->route('admin.settings')->with('error', 'Cannot delete the system default currency.');
        }

        $currency->delete();

        // Clear cache
        Cache::forget('active_currencies');

        return redirect()->route('admin.settings')->with('success', 'Currency deleted successfully.');
    }
}
