<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Faq;
use App\Models\Comment;
use App\Models\Setting;
use App\Models\Estate;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\TwitterCard;


class HomeController extends Controller
{

  public function index()
  {
    $s = Setting::find(1);
    $d = Session::get('applocale') == 'en' ? $s->desc : $s->desc_ar;
    $k = Session::get('applocale') == 'en' ? $s->keywords : $s->keywords_ar;

    SEOMeta::setDescription($d);
    SEOMeta::setCanonical('https://mmsestate.online/home');
    SEOMeta::addKeyword([$k]);

    OpenGraph::setDescription($d);
    OpenGraph::setTitle(__("home.home"));
    OpenGraph::setUrl('https://mmsestate.online');
    TwitterCard::setTitle(__("home.home"));

    return view('home.index', [
      'types' => Estate::types(),
      'cities' => Estate::cities(),
      'maxPrice' => Estate::max('max'),
      'minPrice' => Estate::min('min'),
      'posts' => Post::orderBy('id')->limit(4)->get(),
      'p_count' => Post::all()->count(),
      'faqs' => Faq::where("show_home", 1)->get(),
      'f_count' => Faq::all()->count(),
      'estates' => Estate::orderBy('id')->limit(6)->get(),
      'e_count' => Estate::all()->count(),
    ]);
  }

  public function posts_list()
  {
    SEOMeta::setDescription(__('home.articles'));
    SEOMeta::setCanonical('https://mmsestate.online/posts');
    OpenGraph::setDescription(__('home.articles'));
    OpenGraph::setTitle(__("home.articles"));
    OpenGraph::setUrl('https://mmsestate.online/posts');
    OpenGraph::addProperty('type', 'website');
    TwitterCard::setTitle(__("home.articles"));

    $posts = Post::paginate(9);
    return view('home.pmenu')->with('posts', $posts);
  }

  public function post($slug)
  {
    $post = Post::where('slug', $slug)->first();
    $t = Session::get('applocale') == 'en' ? $post->title : $post->title_ar;
    $d = Session::get('applocale') == 'en' ? $post->short : $post->short_ar;
    $k = Session::get('applocale') == 'en' ? $post->keywords : $post->keywords_ar;

    SEOMeta::setDescription($d);
    SEOMeta::setCanonical('https://mmsestate.online/home');
    SEOMeta::addMeta('article:published_time', $post->created_at->toW3CString(), 'property');
    SEOMeta::addKeyword([$k]);

    OpenGraph::setDescription($d);
    OpenGraph::setTitle($t);
    OpenGraph::setUrl('https://mmsestate.online/post/' . $post->id);
    OpenGraph::addImage($post->image);
    OpenGraph::addProperty('type', 'article');
    TwitterCard::setTitle($t);

    return view('home.post', ['post' => $post, 'comments' => $post->comments]);
  }

  public function estates_list()
  {
    SEOMeta::setDescription(__('home.estates'));
    SEOMeta::setCanonical('https://mmsestate.online/home');
    OpenGraph::setDescription(__('home.estates'));
    OpenGraph::setTitle(__("home.estates"));
    OpenGraph::setUrl('https://mmsestate.online/estates');
    OpenGraph::addProperty('type', 'website');
    TwitterCard::setTitle(__("home.estates"));

    $estates = Estate::paginate(9);
    return view('home.emenu', [
      'estates' => $estates,
      'types' => Estate::types(),
      'cities' => Estate::cities(),
      'maxPrice' => Estate::max('max'),
      'minPrice' => Estate::min('min'),
    ]);
  }

  public function estate($slug)
  {
    $estate = Estate::where('slug', $slug)->first();
    $t = Session::get('applocale') == 'en' ? $estate->title : $estate->title_ar;
    $d = Session::get('applocale') == 'en' ? $estate->short : $estate->short_ar;
    $k = Session::get('applocale') == 'en' ? $estate->keywords : $estate->keywords_ar;

    SEOMeta::setDescription($d);
    SEOMeta::setCanonical('https://mmsestate.online/home');
    SEOMeta::addMeta('estate:published_time', $estate->created_at->toW3CString(), 'property');
    SEOMeta::addKeyword([$k]);

    OpenGraph::setTitle($t);
    OpenGraph::setDescription($d);
    OpenGraph::setUrl('https://mmsestate.online/estate/' . $estate->id);
    OpenGraph::addProperty('type', 'estate');

    TwitterCard::setTitle($t);

    $others = Estate::where("id", "!=", $estate->id)->inRandomOrder()->limit(4)->get();
    return view('home.estate', [
      'estate' => $estate,
      'others' => $others
    ]);
  }

  public function faq()
  {
    SEOMeta::setDescription(__('home.faq'));
    SEOMeta::setCanonical('https://mmsestate.online/home');
    OpenGraph::setDescription(__('home.faq'));
    OpenGraph::setTitle(__("home.faq"));
    OpenGraph::setUrl('https://mmsestate.online/faq');
    OpenGraph::addProperty('type', 'website');
    TwitterCard::setTitle(__("home.faq"));
    return view('home.faq')->with('faqs', Faq::all());
  }

  public function contact()
  {
    SEOMeta::setDescription(__('home.contact'));
    SEOMeta::setCanonical('https://mmsestate.online/home');
    OpenGraph::setDescription(__('home.contact'));
    OpenGraph::setTitle(__("home.contact"));
    OpenGraph::setUrl('https://mmsestate.online/contact');
    OpenGraph::addProperty('type', 'website');
    TwitterCard::setTitle(__("home.contact"));
    return view('home.contact');
  }

  public function about()
  {
    SEOMeta::setDescription(__('home.about'));
    SEOMeta::setCanonical('https://mmsestate.online/home');
    OpenGraph::setDescription(__('home.about'));
    OpenGraph::setTitle(__("home.about"));
    OpenGraph::setUrl('https://mmsestate.online/about');
    OpenGraph::addProperty('type', 'website');
    TwitterCard::setTitle(__("home.about"));
    return view('home.about');
  }

  public function e_filter(Request $request)
  {
    SEOMeta::setDescription(__('home.search_res'));
    SEOMeta::setCanonical('https://mmsestate.online/home');
    OpenGraph::setDescription(__('home.search_res'));
    OpenGraph::setTitle(__("home.search_res"));
    OpenGraph::setUrl('https://mmsestate.online/search');
    OpenGraph::addProperty('type', 'website');
    TwitterCard::setTitle(__("home.search_res"));

    $estates = Estate::where("min", ">=", $request->from)->where("min", "<=", $request->to);
    $estates = ($request->type != 0) ? $estates->where("type", $request->type) : $estates;
    $estates = ($request->city != 0) ? $estates->where("city", $request->city) : $estates;
    $estates = ($request->town != 0) ? $estates->where("town", $request->town) : $estates;
    $estates = $estates->paginate(9);

    return view('home.emenu', [
      'estates' => $estates,
      'title' => __('home.search_res') . '(' . $estates->count() . ')',
      'types' => Estate::types(),
      'cities' => Estate::cities(),
      'maxPrice' => Estate::max('max'),
      'minPrice' => Estate::min('min'),
    ]);
  }

  public function estate_type($type)
  {
    SEOMeta::setDescription(Estate::types()[$type]);
    SEOMeta::setCanonical('https://mmsestate.online/home');
    OpenGraph::setDescription(Estate::types()[$type]);
    OpenGraph::setTitle(Estate::types()[$type]);
    OpenGraph::setUrl('https://mmsestate.online/type/' . $type);
    OpenGraph::addProperty('type', 'website');
    TwitterCard::setTitle(Estate::types()[$type]);

    $estates = Estate::where('type', $type)->paginate(9);
    return view('home.emenu', [
      'estates' => $estates,
      'title' => Estate::types()[$type],
      'nosearch' => 'no',
    ]);
  }

  public function estate_city($city)
  {
    SEOMeta::setDescription(Estate::types()[$city]);
    SEOMeta::setCanonical('https://mmsestate.online/home');
    OpenGraph::setDescription(Estate::types()[$city]);
    OpenGraph::setTitle(Estate::types()[$city]);
    OpenGraph::setUrl('https://mmsestate.online/estate/city/' . $city);
    OpenGraph::addProperty('type', 'website');
    TwitterCard::setTitle(Estate::types()[$city]);

    $estates = Estate::where('city', $city)->paginate(9);
    return view('home.emenu', [
      'estates' => $estates,
      'title' => Estate::cities()[$city],
      'nosearch' => 'no',
    ]);
  }

  public function estate_town($city, $town)
  {
    SEOMeta::setDescription(Estate::towns($city)[$town]);
    SEOMeta::setCanonical('https://mmsestate.online/home');
    OpenGraph::setDescription(Estate::towns($city)[$town]);
    OpenGraph::setTitle(Estate::towns($city)[$town]);
    OpenGraph::setUrl('https://mmsestate.online/estate/' . $city . '/' . $town);
    OpenGraph::addProperty('type', 'website');
    TwitterCard::setTitle(Estate::towns($city)[$town]);

    $estates = Estate::where('town', $town + 1)->paginate(9);
    return view('home.emenu', [
      'estates' => $estates,
      'title' => Estate::towns($city)[$town],
      'nosearch' => 'no',
    ]);
  }


  public function switch_lang()
  {
    if (!Session::get('applocale')) Session::put('applocale', 'ar');
    Session::get('applocale') == 'en' ? Session::put('applocale', 'ar') : Session::put('applocale', 'en');

    return redirect()->back();
  }

  public function Search(Request $request)
  {
    $query = $request["q"];

    $posts = Session::get('applocale') == 'en' ? Post::where('title', 'LIKE', '%' . $query . '%')->get()
      : Post::where('title_ar', 'LIKE', '%' . $query . '%')->get();

    $estates = Session::get('applocale') == 'en' ? Estate::where('title', 'LIKE', '%' . $query . '%')->get()
      : Estate::where('title_ar', 'LIKE', '%' . $query . '%')->get();

    $faqs = Session::get('applocale') == 'en' ? Faq::where('question', 'LIKE', '%' . $query . '%')->orWhere('answer', 'LIKE', '%' . $query . '%')->get()
      : Faq::where('question_ar', 'LIKE', '%' . $query . '%')->orWhere('answer_ar', 'LIKE', '%' . $query . '%')->get();

    return view('home.search', [
      "posts" => $posts,
      "estates" => $estates,
      "faqs" => $faqs,
    ]);
  }
}
