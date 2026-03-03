<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostStoreRequest;
use App\Http\Requests\PostUpdateRequest;
use App\Models\Post;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Inertia\Inertia;

class PostController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', Post::class);

        return Inertia::render('Admin/Post/Index', [
            'posts' => Post::with('user')->paginate(10),
            'translations' => [
                'all_articles' => __('admin.all_articles'),
                'add_article' => __('admin.add_article'),
                'preview' => __('admin.preview'),
                'delete' => __('admin.delete'),
                'edit' => __('admin.edit'),
                'title' => __('admin.title'),
                'content' => __('admin.content'),
                'id' => __('admin.id'),
                'confirm_delete' => __('admin.confirm_delete'),
                'actions' => __('admin.actions'),
                'number' => __('admin.number'),
                'image' => __('admin.image'),
                'writer' => __('admin.writer'),
                'date' => __('admin.date'),
                'article' => __('admin.article'),
            ],
        ]);
    }

    public function create()
    {
        $this->authorize('create', Post::class);

        return Inertia::render('Admin/Post/Create', [
            'translations' => [
                'add_article' => __('admin.add_article'),
                'edit_article' => __('admin.edit_article'),
                'title' => __('admin.title'),
                'en' => __('admin.en'),
                'ar' => __('admin.ar'),
                'slug' => __('admin.slug'),
                'shortmeta' => __('admin.shortmeta'),
                'keywords' => __('admin.keywords'),
                'images' => __('admin.image'),
                'content' => __('admin.content'),
                'save' => __('admin.save'),
                'update' => __('admin.update'),
                'add' => __('admin.add'),
            ],
        ]);
    }

    public function store(PostStoreRequest $request)
    {
        $validated = $request->validated();
        $validated['slug'] = Str::slug($request->slug);

        if ($request->hasFile('image')) {
            $image = $request->file('image')->store('images/posts', 'public');
            $validated['image'] = $image;
        }

        Post::create($validated);

        return redirect()->route('posts.index')->with('success', __('admin.post_created'));
    }

    public function edit(Post $post)
    {
        $this->authorize('update', $post);

        return Inertia::render('Admin/Post/Create', [
            'post' => $post,
            'translations' => [
                'add_article' => __('admin.add_article'),
                'edit_article' => __('admin.edit_article'),
                'title' => __('admin.title'),
                'en' => __('admin.en'),
                'ar' => __('admin.ar'),
                'slug' => __('admin.slug'),
                'shortmeta' => __('admin.shortmeta'),
                'keywords' => __('admin.keywords'),
                'images' => __('admin.image'),
                'content' => __('admin.content'),
                'save' => __('admin.save'),
                'update' => __('admin.update'),
                'add' => __('admin.add'),
            ],
        ]);
    }

    public function update(PostUpdateRequest $request, Post $post)
    {
        $data = $request->validated();
        $data['slug'] = Str::slug($request->slug);

        if ($request->hasFile('image')) {
            $image = $request->file('image')->store('images/posts', 'public');
            $data['image'] = $image;
            if ($post->image) {
                Storage::disk('public')->delete($post->image);
            }
        }

        $post->update($data);

        return redirect()->route('posts.index')->with('success', __('admin.post_updated'));
    }

    public function destroy(Post $post)
    {
        $this->authorize('delete', $post);

        Storage::disk('public')->delete($post->image);
        $post->delete();

        return redirect()->route('posts.index')->with('success', __('admin.post_deleted'));
    }
}
