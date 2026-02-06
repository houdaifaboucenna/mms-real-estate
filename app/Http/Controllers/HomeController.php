<?php

namespace App\Http\Controllers;

use App\Enums\EstateTypeEnum;
use App\Models\City;
use App\Models\Estate;
use App\Models\Faq;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class HomeController extends Controller
{
    public function index()
    {
        return view('home.index', [
            'types' => EstateTypeEnum::labels(),
            'cities' => City::all(),
            'maxPrice' => Estate::max('max'),
            'minPrice' => Estate::min('min'),
            'posts' => Post::orderBy('id')->limit(4)->get(),
            'p_count' => Post::all()->count(),
            'faqs' => Faq::where('show_home', 1)->get(),
            'f_count' => Faq::all()->count(),
            'estates' => Estate::orderBy('id')->limit(6)->get(),
            'e_count' => Estate::all()->count(),
        ]);
    }

    public function posts()
    {
        $posts = Post::paginate(9);

        return view('home.pmenu', ['posts' => $posts]);
    }

    public function post($slug)
    {
        $post = Post::where('slug', $slug)->first();

        return view('home.post', ['post' => $post, 'comments' => $post->comments]);
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
        $estate = Estate::where('slug', $slug)->first();
        $others = Estate::where('id', '!=', $estate->id)->inRandomOrder()->limit(4)->get();

        return view('home.estate', [
            'estate' => $estate,
            'others' => $others,
        ]);
    }

    public function faq()
    {
        return view('home.faq', ['faqs' => Faq::all()]);
    }

    public function contact()
    {
        return view('home.contact');
    }

    public function about()
    {
        return view('home.about');
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
