<?php

namespace App\Http\Middleware;

use App\Enums\EstateTypeEnum;
use App\Models\Estate;
use App\Models\Post;
use Illuminate\Http\Request;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        return [
            ...parent::share($request),
            'auth' => [
                'user' => $request->user(),
            ],
            'locale' => session('lang', 'en'),
            'settings' => [
                'phone' => setting('phone'),
                'whatsapp' => setting('whatsapp'),
                'facebook' => setting('facebook'),
                'instagram' => setting('instagram'),
                'twitter' => setting('twitter'),
                'telegram' => setting('telegram'),
                'linkedin' => setting('linkedin'),
            ],
            'flash' => [
                'success' => $request->session()->get('success'),
            ],
            'latestPosts' => Post::latest()->limit(3)->get(['id', 'title', 'title_ar', 'slug']),
            'propertyTypes' => collect(EstateTypeEnum::labels())->map(fn($label, $key) => [
                'key' => $key,
                'label' => $label,
                'count' => Estate::where('type', $key)->count(),
            ])->values(),
            'translations' => [
                'latest_articles' => __('home.latest_articles'),
                'property_types' => __('home.property_types'),
                'stay_connected' => __('home.stay_connected'),
                'contact_us' => __('home.contact_us'),
                'copyright' => __('home.copyright'),
                'search' => __('home.search'),
            ],
        ];
    }
}
