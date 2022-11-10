<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Post;

class UserController extends Controller
{
    public function all()
    {
        $users = User::orderByDesc('id')->paginate(30);
        return view('user.all')->withUsers($users);
    }

    public function show($name)
    {
    	$user = User::where('name',$name)->first();;
    	return view('user.show')->withUser($user);
    }

    public function userPosts($name)
    {   
        $user = User::where('name', $name)->first();
        $posts = Post::where('user_id',$user->id)->orderByDesc('id')->paginate(30);
        return view('user.allUserPosts')->withPosts($posts);
    }

    public function likedPosts()
    {
        $likes = auth()->user()->likesPost()->where('like','=', 1)->orderByDesc('id')->paginate(30);
        $posts = null;
        $niz = null;
        if ($likes != null and !empty($likes)) {
            foreach($likes as $like){
                $niz[] = $like->post;
            }
        $posts = collect($niz);
        return view('user.likedPosts')->withPosts($posts)->withLikes($likes);
        }else{
            return view('user.likedPosts')->withPosts($posts)->withLikes($likes);
        }
    }
}
