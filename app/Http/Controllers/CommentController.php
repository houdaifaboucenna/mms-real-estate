<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{

    public function index()
    {
        return view("admin.comments.index",["comments"=>Comment::all()]);
    }

    public function store(Request $request)
    {
        Comment::create([
          "name" => $request->name,
          "email" => $request->email,
          "content" => $request->content,
          "post_id" => $request->post_id,
        ]);

        // session()->flash('success', 'تم استلام تعليقك, سيتم نشره بعد فحصه');
        session()->flash('success', __("admin.comment_received"));

        return redirect()->back();
    }

    public function destroy(Comment $comment)
    {
      $comment->delete();

      // session()->flash('success', 'تم حذف التعليق بنجاح');
      session()->flash('success', __("admin.comment_deleted"));

      return redirect()->route('comments.index');
    }
}
