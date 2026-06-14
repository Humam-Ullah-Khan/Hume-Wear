<?php

namespace App\Providers;

use App\Models\Setting;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        View::share('siteSettings', [
            'phone' => Setting::get('contact_phone', '+92 342 099 0948'),
            'whatsapp' => Setting::get('contact_whatsapp', '+92 323 125 6645'),
            'email' => Setting::get('contact_email', 'humamullahkhan001@gmail.com'),
            'address' => Setting::get('contact_address', 'Online Business'),
            'instagram' => Setting::get('social_instagram', ''),
            'facebook' => Setting::get('social_facebook', ''),
            'youtube' => Setting::get('social_youtube', ''),
            'tiktok' => Setting::get('social_tiktok', ''),
        ]);
    }
}
