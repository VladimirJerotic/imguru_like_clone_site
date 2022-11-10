<?php

namespace App\Http\Controllers;

use App\LikePost;
use Illuminate\Http\Request;

class LikePostController extends Controller
{

    public function index(Request $request)
    {
        $likes = LikePost::all()->where('user_id',auth()->user()->id)->where('post_id',$request->post_id)->first();
        //dd($request);
        $isLike = $request->like;
        if ($likes == null) {
            $like = new LikePost;
            $like->user_id = auth()->user()->id;
            $like->post_id = $request->post_id;
            $like->like = $isLike;
            $like->save();
        }else{
            $likes->like = $isLike;
            $likes->save();
        }
    }

    public function destroy(Request $request)
    {
        $likes = LikePost::all()->where('user_id',auth()->user()->id)->where('post_id',$request->post_id)->first();
        //dd($likes);
        $likes->delete();
    }

}
