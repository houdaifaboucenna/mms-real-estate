<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\App;

class LanguageController extends Controller
{
    public function switchLang()
    {
        $lang = isLang('en') ? 'ar' : 'en';
        session(['lang' => $lang]);
        App::setLocale($lang);

        return redirect()->back();
    }
}
