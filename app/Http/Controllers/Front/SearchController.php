<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Estate;
use App\Models\Faq;
use App\Models\Post;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $query = $request['q'];

        $posts = isLang('en')
            ? Post::where('title', 'LIKE', '%' . $query . '%')->get()
            : Post::where('title_ar', 'LIKE', '%' . $query . '%')->get();

        $estates = isLang('en')
            ? Estate::with('city', 'town')->where('title', 'LIKE', '%' . $query . '%')->get()
            : Estate::with('city', 'town')->where('title_ar', 'LIKE', '%' . $query . '%')->get();

        $faqs = isLang('en')
            ? Faq::where('question', 'LIKE', '%' . $query . '%')->orWhere('answer', 'LIKE', '%' . $query . '%')->get()
            : Faq::where('question_ar', 'LIKE', '%' . $query . '%')->orWhere('answer_ar', 'LIKE', '%' . $query . '%')->get();

        return Inertia::render('Search', [
            'posts' => $posts,
            'estates' => $estates,
            'faqs' => $faqs,
            'translations' => [
                'search_res' => __('home.search_res'),
                'articles' => __('home.articles'),
                'estates' => __('home.estates'),
                'faq' => __('home.faq'),
                'nofound' => __('home.nofound'),
                'nofound_desc' => __('home.nofound_desc'),
                'back_to_home' => __('home.back_to_home'),
                'view_details' => __('home.view_details'),
            ],
        ]);
    }
}
