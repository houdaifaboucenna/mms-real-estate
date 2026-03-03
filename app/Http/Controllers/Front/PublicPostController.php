<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Requests\CommentStoreRequest;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;

class PublicPostController extends Controller
{
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

    public function post(Post $post)
    {
        return Inertia::render('PostShow', [
            'post' => $post->load('comments'),
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

    public function storeComment(CommentStoreRequest $request): RedirectResponse
    {
        Comment::create($request->validated());

        return back()->with('success', __('admin.comment_received'));
    }
}
