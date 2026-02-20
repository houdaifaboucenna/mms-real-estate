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

    public function estates()
    {
        $estates = Estate::paginate(9);

        return view('home.emenu', [
            'estates' => $estates,
            'types' => EstateTypeEnum::labels(),
            'cities' => City::all(),
            'maxPrice' => Estate::max('max'),
            'minPrice' => Estate::min('min'),
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
                'view_details' => __('home.View Details'),
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

    public function filterEstate(Request $request)
    {
        $estates = Estate::where('min', '>=', $request->from)->where('min', '<=', $request->to);
        $estates = ($request->type != 0) ? $estates->where('type', $request->type) : $estates;
        $estates = ($request->city != 0) ? $estates->where('city', $request->city) : $estates;
        $estates = ($request->town != 0) ? $estates->where('town', $request->town) : $estates;
        $estates = $estates->paginate(9);

        return view('home.emenu', [
            'estates' => $estates,
            'title' => __('home.search_res') . '(' . $estates->count() . ')',
            'types' => EstateTypeEnum::labels(),
            'cities' => City::all(),
            'maxPrice' => Estate::max('max'),
            'minPrice' => Estate::min('min'),
        ]);
    }

    public function filterByType($type)
    {
        $estates = Estate::where('type', $type)->paginate(9);

        return view('home.emenu', [
            'estates' => $estates,
            'title' => EstateTypeEnum::labels()[$type],
            'nosearch' => 'no',
        ]);
    }

    public function filterByCity($city)
    {
        $estates = Estate::where('city', $city)->paginate(9);

        return view('home.emenu', [
            'estates' => $estates,
            'title' => City::find($city)->name,
            'nosearch' => 'no',
        ]);
    }

    public function filterByTown($city, $town)
    {
        $estates = Estate::where('town', $town + 1)->paginate(9);

        return view('home.emenu', [
            'estates' => $estates,
            'title' => Estate::towns($city)[$town],
            'nosearch' => 'no',
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
            ? Estate::where('title', 'LIKE', '%' . $query . '%')->get()
            : Estate::where('title_ar', 'LIKE', '%' . $query . '%')->get();

        $faqs = isLang('en')
            ? Faq::where('question', 'LIKE', '%' . $query . '%')->orWhere('answer', 'LIKE', '%' . $query . '%')->get()
            : Faq::where('question_ar', 'LIKE', '%' . $query . '%')->orWhere('answer_ar', 'LIKE', '%' . $query . '%')->get();

        return view('home.search', [
            'posts' => $posts,
            'estates' => $estates,
            'faqs' => $faqs,
        ]);
    }
}
