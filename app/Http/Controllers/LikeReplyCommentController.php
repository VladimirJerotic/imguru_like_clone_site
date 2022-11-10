<?php

namespace App\Http\Controllers;

use App\LikeReplyComment;
use Illuminate\Http\Request;

class LikeReplyCommentController extends Controller
{
    public function index(Request $request)
    {
        $likes = LikeReplyComment::all()->where('user_id',auth()->user()->id)->where('post_id',$request->post_id)->where('reply_comment_id',$request->reply_id)->first();
        //dd($request);
        $isLike = $request->like;
        if ($likes == null) {
            $like = new LikeReplyComment;
            $like->user_id = auth()->user()->id;
            $like->reply_comment_id = $request->reply_id;
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
        $likes = LikeReplyComment::all()->where('user_id',auth()->user()->id)->where('post_id',$request->post_id)->where('reply_comment_id',$request->reply_id)->first();
        //dd($likes);
        $likes->delete();
    }
}
