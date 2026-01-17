<?php

use App\Models\Setting;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;

if (! function_exists('setting')) {
    function setting(string $name, ?string $default = null): ?string
    {
        return Cache::memo()->remember("app_setting_{$name}", 60 * 60 * 24, fn(): ?string => Setting::where('name', $name)->first()?->value ?? $default);
    }
}

if (! function_exists('isLang')) {
    function isLang($lang)
    {
        return Session::get('lang') == $lang;
    }
}
