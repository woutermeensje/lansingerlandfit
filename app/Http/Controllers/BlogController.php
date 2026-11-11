<?php

namespace App\Http\Controllers;

use App\Support\Blog;
use Illuminate\View\View;

class BlogController extends Controller
{
    public function index(): View
    {
        return view('pages.blogs', ['posts' => Blog::all()]);
    }

    public function show(string $slug): View
    {
        return view('pages.blog', ['post' => Blog::find($slug) ?? abort(404)]);
    }
}
