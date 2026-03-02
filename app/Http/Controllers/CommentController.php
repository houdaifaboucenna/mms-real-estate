<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class CommentController extends Controller
{
    public function index(): Response
    {
        $comments = Comment::with('post:id,title,slug')->latest()->get()->map(function ($comment) {
            return [
                'id' => $comment->id,
                'name' => $comment->name,
                'email' => $comment->email,
                'content' => $comment->content,
                'gravatar' => getGravatar($comment->email),
                'date' => $comment->created_at->format('d/m/Y'),
                'post' => $comment->post,
            ];
        });

        return Inertia::render('Admin/Comment/Index', [
            'comments' => $comments,
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

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'content' => 'required',
            'post_id' => 'required|exists:posts,id',
        ]);

        Comment::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'content' => $validated['content'],
            'post_id' => $validated['post_id'],
        ]);

        return back()->with('success', __('admin.comment_received'));
    }

    public function destroy(Comment $comment): RedirectResponse
    {
        $comment->delete();

        return redirect()->route('comments.index')->with('success', __('admin.comment_deleted'));
    }
}
