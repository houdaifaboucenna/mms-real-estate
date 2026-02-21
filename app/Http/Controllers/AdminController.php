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
            'posts' => Post::all(),
            'estates' => Estate::all(),
            'contacts' => Contact::all(),
            'comments' => Comment::all(),
        ]);
    }
}
