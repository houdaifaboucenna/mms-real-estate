<?php

namespace App\Http\Controllers\Front;

use App\Enums\EstateTypeEnum;
use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Estate;
use App\Models\Faq;
use App\Models\Post;
use Inertia\Inertia;

class PageController extends Controller
{
    public function home()
    {
        return Inertia::render('Home', [
            'types' => EstateTypeEnum::labels(),
            'cities' => City::all(),
            'maxPrice' => Estate::max('max'),
            'minPrice' => Estate::min('min'),
            'posts' => Post::orderBy('id')->limit(4)->get(),
            'postCount' => Post::count(),
            'faqs' => Faq::where('show_home', 1)->get(),
            'faqCount' => Faq::count(),
            'estates' => Estate::orderBy('id')->limit(6)->get(),
            'estateCount' => Estate::count(),
        ]);
    }

    public function faq()
    {
        return Inertia::render('Faq', [
            'faqs' => Faq::all(),
            'translations' => [
                'faq' => __('home.faq'),
                'faq_header' => __('home.Find answers to common questions about our real estate services.'),
                'contact_form' => __('home.contact_form'),
            ],
        ]);
    }

    public function about()
    {
        return Inertia::render('About', [
            'translations' => [
                'about' => __('home.about'),
                'who' => __('home.who'),
                'who_txt' => __('home.who_txt'),
                'vision' => __('home.vision'),
                'vision_txt' => __('home.vision_txt'),
                'mission' => __('home.mission'),
                'mission_txt' => __('home.mission_txt'),
            ],
        ]);
    }
}
