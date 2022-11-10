<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'post_id', 'comment_text'
    ];
    
	public function post()
    {
    	return $this->belongsTo('App\Post');
    }

    public function user()
    {
    	return $this->belongsTo('App\User');
    }

    public function likes()
    {
        return $this->hasMany('App\LikeComment');
    }

    public function replyComment()
    {
        return $this->hasMany('App\ReplyComment');
    }
}
