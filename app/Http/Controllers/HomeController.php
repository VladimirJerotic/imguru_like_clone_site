<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
class HomeController extends Controller
{
    public function index()
    {
    	$posts = Post::orderByDesc('id')->paginate(1);
    	return view('home.index')->withPosts($posts);
    }
}
