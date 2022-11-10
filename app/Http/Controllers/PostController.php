<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use Session;
use Image;
use Storage;

class PostController extends Controller
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
                'post_text' => 'max:255',
                'post_img' => 'required|image'
            ]);
        $post = new Post;
        $post->user_id = auth()->user()->id;
        $post->post_text = $request->post_text;
        //image
        $image = $request->post_img;
        $filename = time() . '.' .$image->getClientOriginalExtension();
        $location = public_path('postImages/'.$filename);
        Image::make($image)->save($location);
        $post->post_img = $filename;
        //end image
        if ($post->save()) {
            Session::flash('success', 'Post has been created');
            return redirect()->route('home.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::findOrFail($id);
        return view('posts.show')->withPost($post);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Post::findOrFail($id);
        if (auth()->user()->id != $post->user->id) 
        {
            return redirect()->route('post.show',$post->id);
        }
        return view('posts.edit')->withPost($post);
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
        $request->validate(
            [
                'post_text' => 'max:255',
                'post_img' => 'image'
            ]);
        $post = Post::findOrFail($id);
        if (auth()->user()->id != $post->user->id) 
        {
            return redirect()->route('post.show',$post->id);
        }
        if ($request->hasFile('post_img')) 
        {
             //image
            $image = $request->post_img;
            $filename = time() . '.' .$image->getClientOriginalExtension();
            $location = public_path('postImages/'.$filename);
            //Delete old image
            $oldFileName = $post->post_img;
            Storage::disk('public')->delete($oldFileName);
            //End delete old image
            Image::make($image)->save($location);
            $post->post_img = $filename;
            //end image
        }
        $post->post_text = $request->post_text;
        if ($post->save()) 
        {
            Session::flash('success', 'Post has been updated');
            return redirect()->route('post.show',$post->id);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        if (auth()->user()->id != $post->user->id) 
        {
            return redirect()->route('post.show',$post->id);
        }
        foreach($post->comments as $comment){
            if ($comment->comment_img != null) {
                Storage::disk('commentImages')->delete($comment->comment_img);
                foreach($comment->replyComment as $reply){
                    if ($reply->reply_comment_img != null) {
                        Storage::disk('commentImages')->delete($reply->reply_comment_img);
                    }
                }
            }
        }
        Storage::disk('public')->delete($post->post_img);
        if ($post->delete()) {
            Session::flash('success','Post was deleted');
            return redirect()->route('home.index');
        }
    }
}
