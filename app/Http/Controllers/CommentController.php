<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentStoreRequest;
use App\Models\Comment;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class CommentController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Admin/Comment/Index', [
            'comments' => Comment::with('post:id,title,slug')->latest()->paginate(10),
            'translations' => [
                'comments' => __('admin.comments'),
                'all_comments' => __('admin.all_comments'),
                'number' => __('admin.number'),
                'name' => __('admin.name'),
                'email' => __('admin.email'),
                'image' => __('admin.image'),
                'comment' => __('admin.comment'),
                'date' => __('admin.date'),
                'article' => __('admin.article'),
                'actions' => __('admin.actions'),
                'delete' => __('admin.delete'),
                'confirm_delete' => __('admin.confirm_delete'),
            ],
        ]);
    }

    public function store(CommentStoreRequest $request): RedirectResponse
    {
        Comment::create($request->validated());

        return back()->with('success', __('admin.comment_received'));
    }

    public function destroy(Comment $comment): RedirectResponse
    {
        $comment->delete();

        return redirect()->route('comments.index')->with('success', __('admin.comment_deleted'));
    }
}
