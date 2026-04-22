<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        \Illuminate\Support\Facades\Event::listen(function (\SocialiteProviders\Manager\SocialiteWasCalled $event) {
            $event->extendSocialite('apple', \SocialiteProviders\Apple\Provider::class);
        });

        view()->composer('*', function ($view) {
            $raw = \App\Models\Setting::all();
            $tool_settings = [
                'tool_title' => 'Social Media Engagement Calculator',
                'cta_text' => 'Get Started',
                'primary_color' => '#85f43a',
                'dark_mode_bg' => '#272727',
                'guest_limit' => 2,
                'auth_limit' => 3,
                'guest_limit' => 2,
                'auth_limit' => 3,
                'er_viral' => 6,
                'er_high' => 3,
                'white_label_active' => '0',
                'custom_client_title' => 'Social Media Engagement Calculator',
                'custom_logo_path' => ''
            ];
            foreach($raw as $s) {
                $tool_settings[$s->key] = $s->value;
            }
            $view->with('tool_settings', $tool_settings);
        });
    }
}
