<?php

namespace App\Http\Controllers;

use App\Models\Estate;
use App\Models\Post;
use Inertia\Inertia;

class TrashController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/Trash/Index', [
            'estates' => Estate::onlyTrashed()->with(['town', 'city'])->latest()->paginate(10),
            'posts' => Post::onlyTrashed()->with('user')->latest()->paginate(10),
            'translations' => [
                'trash' => __('admin.trash'),
                'articles' => __('admin.articles'),
                'estates' => __('admin.estates'),
                'number' => __('admin.number'),
                'title' => __('admin.title'),
                'writer' => __('admin.writer'),
                'date' => __('admin.date'),
                'actions' => __('admin.actions'),
                'restore' => __('admin.restore'),
                'force_delete' => __('admin.force_delete'),
                'confirm_delete' => __('admin.confirm_delete'),
            ],
        ]);
    }

    public function restore(string $id, string $type)
    {
        if ($type === 'estate') {
            Estate::onlyTrashed()->findOrFail($id)->restore();
        } elseif ($type === 'post') {
            Post::onlyTrashed()->findOrFail($id)->restore();
        }

        return to_route('trash.index')->with('success', __('admin.item_restored'));
    }

    public function forceDelete(string $id, string $type)
    {
        if ($type === 'estate') {
            Estate::onlyTrashed()->findOrFail($id)->forceDelete();
        } elseif ($type === 'post') {
            Post::onlyTrashed()->findOrFail($id)->forceDelete();
        }

        return to_route('trash.index')->with('success', __('admin.item_deleted_permanently'));
    }
}
