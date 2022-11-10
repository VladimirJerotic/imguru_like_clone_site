<?php

namespace App\Http\Controllers;

use App\LikeComment;
use Illuminate\Http\Request;

class LikeCommentController extends Controller
{

    public function index(Request $request)
    {
        $likes = LikeComment::all()->where('user_id',auth()->user()->id)->where('post_id',$request->post_id)->where('comment_id',$request->comment_id)->first();
        //dd($request);
        $isLike = $request->like;
        if ($likes == null) {
            $like = new LikeComment;
            $like->user_id = auth()->user()->id;
            $like->comment_id = $request->comment_id;
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
        $likes = LikeComment::all()->where('user_id',auth()->user()->id)->where('post_id',$request->post_id)->where('comment_id',$request->comment_id)->first();
        //dd($likes);
        $likes->delete();
    }

}
