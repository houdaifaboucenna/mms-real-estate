<?php

namespace App\Http\Controllers;

use App\Enums\EstateTypeEnum;
use App\Models\Comment;
use App\Models\Contact;
use App\Models\Estate;
use App\Models\Post;
use Inertia\Inertia;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return Inertia::render('Admin/Dashboard', [
            'estates_by_city' => Inertia::defer(
                fn () => Estate::with('city')
                    ->get()
                    ->groupBy('city_id')
                    ->map(fn ($group) => [
                        'name' => $group->first()->city->name ?? 'Unknown',
                        'name_ar' => $group->first()->city->name_ar ?? 'غير معروف',
                        'count' => $group->count(),
                    ])->values(),
                'charts'
            ),
            'estates_by_type' => Inertia::defer(
                fn () => Estate::all()
                    ->groupBy('type')
                    ->map(fn ($group, $type) => [
                        'type' => $type,
                        'label' => EstateTypeEnum::labels()[$type] ?? $type,
                        'count' => $group->count(),
                    ])->values(),
                'charts'
            ),
            'posts_count' => Inertia::defer(fn () => Post::count(), 'stats'),
            'estates_count' => Inertia::defer(fn () => Estate::count(), 'stats'),
            'contacts_count' => Inertia::defer(fn () => Contact::count(), 'stats'),
            'comments_count' => Inertia::defer(fn () => Comment::count(), 'stats'),
        ]);
    }
}
