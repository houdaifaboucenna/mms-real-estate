<?php

namespace App\Http\Controllers;

use App\Enums\EstateTypeEnum;
use App\Models\City;
use App\Models\Estate;
use App\Models\Faq;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function index()
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

    public function posts()
    {
        return Inertia::render('Posts', [
            'posts' => Post::paginate(9),
            'translations' => [
                'posts' => __('home.posts'),
                'all_articles' => __('home.all_articles'),
            ],
        ]);
    }

    public function post($slug)
    {
        $post = Post::where('slug', $slug)->first();

        return Inertia::render('PostShow', [
            'post' => $post,
            'comments' => $post->comments,
            'translations' => [
                'post' => __('home.post'),
                'all_articles' => __('home.all_articles'),
                'add_comment' => __('home.add_comment'),
                'comments' => __('home.comments'),
                'name' => __('home.name'),
                'email' => __('home.email'),
                'be_first_comment' => __('home.No comments yet. Be the first to comment!'),
                'content' => __('home.content'),
                'contact_form' => __('home.contact_form'),
            ],
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

    public function contact()
    {
        return Inertia::render('Contactus', [
            'translations' => [
                'address' => __('home.address'),
                'adrs' => __('home.adrs'),
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

    public function estate($slug)
    {
        $estate = Estate::with('city', 'town')->where('slug', $slug)->first();

        return Inertia::render('EstateShow', [
            'estate' => $estate,
            'others' => Estate::with('city', 'town')->where('id', '!=', $estate->id)->inRandomOrder()->limit(4)->get(),
            'translations' => [
                'estate' => __('home.estate'),
                'similar' => __('home.similar'),
                'contact_form' => __('home.contact_form'),
                'city' => __('home.city'),
                'town' => __('home.town'),
                'type' => __('home.type'),
                'price' => __('home.price'),
                'interested_in_this_property' => __('home.Interested in this property?'),
                'all_details_and_legal_consultation' => __('home.Our investment experts are ready to provide you with all details and legal consultation.'),
                'whatsapp_consultation' => __('home.WhatsApp Consultation'),
                'overview_and_details' => __('home.Overview & Details'),
                'view_details' => __('home.view_details'),
            ],
        ]);
    }

    public function estates()
    {
        return Inertia::render('Estates', [
            'estates' => Estate::with('city', 'town')->paginate(9),
            'types' => EstateTypeEnum::labels(),
            'cities' => City::with('towns')->get(),
            'maxPrice' => Estate::max('max') ?? 1000,
            'minPrice' => Estate::min('min') ?? 0,
            'translations' => [
                'estates' => __('home.estates'),
                'all_estates' => __('home.all_estates'),
                'nofound' => __('home.nofound'),
                'home' => __('home.home'),
                'min_price' => __('home.min_price'),
                'max_price' => __('home.max_price'),
                'reset_filters' => __('home.Reset all filters'),
                'adjust_filters' => __('home.Try adjusting your filters to find what you looking for.'),
                'city' => __('home.city'),
                'town' => __('home.town'),
                'type' => __('home.type'),
                'price' => __('home.price'),
                'ch_city' => __('home.ch_city'),
                'ch_town' => __('home.ch_town'),
                'ch_type' => __('home.ch_type'),
                'search' => __('home.search'),
                'view_details' => __('home.view_details'),
            ],
        ]);
    }

    public function filterEstate(Request $request)
    {
        $request->validate([
            'from' => 'nullable|numeric',
            'to' => 'nullable|numeric',
            'type' => 'nullable|string',
            'city' => 'nullable|numeric',
            'town' => 'nullable|numeric',
        ]);
        $estates = Estate::query()->with('city', 'town')
            ->when($request->filled('from'), function ($query) use ($request) {
                $query->where('min', '>=', $request->from);
            })
            ->when($request->filled('to'), function ($query) use ($request) {
                $query->where('min', '<=', $request->to);
            })
            ->when($request->filled('type'), function ($query) use ($request) {
                $query->where('type', $request->type);
            })
            ->when($request->filled('city'), function ($query) use ($request) {
                $query->whereRelation('city', 'cities.id', $request->city);
            })
            ->when($request->filled('town'), function ($query) use ($request) {
                $query->where('town_id', $request->town);
            })
            ->paginate(9);

        return Inertia::render('Estates', [
            'estates' => $estates,
            'title' => __('home.search_res') . '(' . $estates->count() . ')',
            'types' => EstateTypeEnum::labels(),
            'cities' => City::with('towns')->get(),
            'maxPrice' => Estate::max('max') ?? 1000,
            'minPrice' => Estate::min('min') ?? 0,
            'translations' => [
                'estates' => __('home.estates'),
                'all_estates' => __('home.all_estates'),
                'nofound' => __('home.nofound'),
                'city' => __('home.city'),
                'town' => __('home.town'),
                'type' => __('home.type'),
                'price' => __('home.price'),
                'ch_city' => __('home.ch_city'),
                'ch_town' => __('home.ch_town'),
                'ch_type' => __('home.ch_type'),
                'search' => __('home.search'),
                'view_details' => __('home.view_details'),
                'max_price' => __('home.max_price'),
                'min_price' => __('home.min_price'),
                'reset_filters' => __('home.Reset all filters'),
                'adjust_filters' => __('home.Try adjusting your filters to find what you looking for.'),
            ],
        ]);
    }

    public function switchLang()
    {
        $lang = isLang('en') ? 'ar' : 'en';
        session(['lang' => $lang]);
        App::setLocale($lang);

        return redirect()->back();
    }

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
