<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Contact;
use App\Models\Estate;
use App\Models\Comment;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('admin.dashboard',[
          "posts"=>Post::all(),
          "estates"=>Estate::all(),
          "contacts"=>Contact::all(),
          "comments"=>Comment::all(),
        ]);
    }
}
