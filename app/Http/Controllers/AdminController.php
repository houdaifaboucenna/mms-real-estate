<?php

namespace App\Http\Controllers;

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
            'stats' => [
                'posts_count' => Post::count(),
                'estates_count' => Estate::count(),
                'contacts_count' => Contact::count(),
                'comments_count' => Comment::count(),
            ],
            'estates_by_city' => Estate::with('city')
                ->get()
                ->groupBy('city_id')
                ->map(fn($group) => [
                    'name' => $group->first()->city->name ?? 'Unknown',
                    'name_ar' => $group->first()->city->name_ar ?? 'غير معروف',
                    'count' => $group->count(),
                ])->values(),
            'estates_by_type' => Estate::all()
                ->groupBy('type')
                ->map(fn($group, $type) => [
                    'type' => $type,
                    'label' => \App\Enums\EstateTypeEnum::labels()[$type] ?? $type,
                    'count' => $group->count(),
                ])->values(),
        ]);
    }
}
