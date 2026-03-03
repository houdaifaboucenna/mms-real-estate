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
            'estates_by_city' => Estate::with('city')
                ->get()
                ->groupBy('city_id')
                ->map(fn ($group) => [
                    'name' => $group->first()->city->name ?? 'Unknown',
                    'name_ar' => $group->first()->city->name_ar ?? 'غير معروف',
                    'count' => $group->count(),
                ])->values(),
            'estates_by_type' => Estate::all()
                ->groupBy('type')
                ->map(fn ($group, $type) => [
                    'type' => $type,
                    'label' => EstateTypeEnum::labels()[$type] ?? $type,
                    'count' => $group->count(),
                ])->values(),
            'posts_count' => Inertia::defer(fn () => Post::count()),
            'estates_count' => Inertia::defer(fn () => Estate::count()),
            'contacts_count' => Inertia::defer(fn () => Contact::count()),
            'comments_count' => Inertia::defer(fn () => Comment::count()),
        ]);
    }
}
