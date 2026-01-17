<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PostController extends Controller
{
    public function index(post $post)
    {
        return view('admin.posts.index', ['posts' => Post::all()]);
    }

    public function create()
    {
        return view('admin.posts.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|unique:posts',
            'content' => 'required',
            'title_ar' => 'required|unique:posts',
            'content_ar' => 'required',
            'short' => 'nullable',
            'short_ar' => 'nullable',
            'keywords' => 'nullable',
            'keywords_ar' => 'nullable',
            'user_id' => 'required',
            'slug' => 'required',
        ]);

        $validated['slug'] = Str::slug($request->slug);

        if ($request->hasFile('image')) {
            $image = $request['image']->store('images\posts', 'public');
            $validated['image'] = $image;
        }

        session()->flash('success', __('admin.post_created'));

        $posts = Post::create($validated);

        return redirect()->route('posts.index');
    }

    public function edit(post $post)
    {
        return view('admin.posts.create', ['post' => $post]);
    }

    public function update(Request $request, Post $post)
    {
        $data = $request->validate([
            'title' => 'required|unique:posts,title,' . $post->id,
            'content' => 'required',
            'title_ar' => 'required|unique:posts,title,' . $post->id,
            'content_ar' => 'required',
            'short' => 'nullable',
            'short_ar' => 'nullable',
            'keywords' => 'nullable',
            'keywords_ar' => 'nullable',
            'slug' => 'required',
        ]);

        $data['slug'] = Str::slug($request->slug);

        if ($request->hasFile('image')) {
            $image = $request->image->store('images\posts', 'public');
            Storage::disk('public')->delete($post->image);
            $data['image'] = $image;
        }

        session()->flash('success', __('admin.post_updated'));

        $post->update($data);

        return redirect()->route('posts.index');
    }

    public function destroy(post $post)
    {
        DB::delete('delete from comments where post_id = ?', [$post->id]);
        Storage::disk('public')->delete($post->image);
        $post->delete();

        return redirect()->route('posts.index');
    }
}
