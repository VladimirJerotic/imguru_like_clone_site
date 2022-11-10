<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Comment;
use Session;
use Image;
use Storage;
use App\Notifications\NotifyPostOwner;

class CommentController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate(
            [
                'comment_text' => 'required|max:255',
                'comment_img' => 'image'
            ]);
        $comment = new Comment;
        if ($request->has('comment_img')) 
        {
            //image
            $image = $request->comment_img;
            $filename = time() . '.' .$image->getClientOriginalExtension();
            $location = public_path('commentImages/'.$filename);
            Image::make($image)->save($location);
            $comment->comment_img = $filename;
            //end image
        }
        $comment->user_id = auth()->user()->id;
        $comment->post_id = $request->post_id;
        $comment->comment_text = $request->comment_text;
        if ($comment->save()) {
            /*Notifikacija*/
            if ($comment->user_id != $comment->post->user->id) {
                $post = $comment->post;
                $user = $post->user->notify(new NotifyPostOwner($post, auth()->user()));
            }
            /*Kraj Notifikacija*/
            Session::flash('success', 'Comment Succesfuly Created');
            return redirect()->back();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $comment = Comment::findOrFail($id);
        if (auth()->user()->id != $comment->user->id || auth()->user()->id != $comment->post->user->id) 
        {
            return redirect()->route('post.show',$comment->post->id);
        }
        Storage::disk('commentImages')->delete($comment->comment_img);
        if ($comment->delete()) {
            Session::flash('Post was deleted');
            return redirect()->route('dashboard');
        }
    }
}
