<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ReplyComment;
use Session;
use Image;
use App\Notifications\NotifyCommentOwner;
use App\Notifications\NotifyReplyCommentOwner;

class ReplyCommentController extends Controller
{
	//Creating a reply comment
    public function index(Request $request)
    {
    	$request->validate([
    		'post_id' => 'required|integer',
    		'comment_id' => 'required|integer',
    		'reply_comment_text' => 'required|max:255',
    		'reply_comment_img' => 'image',
            'reply_id' => 'integer'
    	]);
    	$reply = new ReplyComment;
    	if ($request->has('reply_comment_img')) 
        {
            //image
            $image = $request->reply_comment_img;
            $filename = time() . '.' .$image->getClientOriginalExtension();
            $location = public_path('commentImages/'.$filename);
            Image::make($image)->save($location);
            $reply->reply_comment_img = $filename;
            //end image
        }
        if ($request->has('reply_id')) {
            $reply->reply_id = $request->reply_id;
        }
        $reply->user_id = auth()->user()->id;
        $reply->comment_id = $request->comment_id;
        $reply->post_id = $request->post_id;
        $reply->reply_comment_text = $request->reply_comment_text;
        if ($reply->save()) {
            /*Notifikacija*/
            if ($reply->reply_id == 0) {
                if ($reply->user_id != $reply->comment->user_id) {
                    $comment = $reply->comment;
                    $user = $comment->user->notify(new NotifyCommentOwner($comment, auth()->user()));
                }
            }
            else{
                $replyComment = ReplyComment::findOrFail($reply->reply_id); 
                if($reply->user_id != $replyComment->user_id){
                    // $replyComment = ReplyComment::findOrFail($reply->reply_id);
                    $user = $replyComment->user->notify(new NotifyReplyCommentOwner($replyComment, auth()->user()));
                }
            }
            /*Kraj Notifikacija*/
            Session::flash('success', 'Reply Succesfuly Created');
            return redirect()->back();
        }
    }
}
