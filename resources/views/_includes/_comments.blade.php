@php
  use App\ReplyComment;
@endphp
<div class="field" id="comments">
    <p class="title is-3"><i class="fa fa-comments" aria-hidden="true"></i>{{$post->comments->count()}} Comments</p>
    @foreach($post->comments as $comment)
         <article class="media">
          <figure class="media-left">
            <p class="image is-64x64">
              <a href="{{ route('user.show',$comment->user->name) }}"><img src="{{$comment->user->profile_img}}"></a>
            </p>
          </figure>
          <div class="media-content">
            <div class="content">
              <p>
                <strong><a href="{{ route('user.show',$comment->user->name) }}">{{$comment->user->name}}</a></strong>
                <p class="comment_text_style">{{$comment->comment_text}}</p>
                @if($comment->comment_img != null || !empty($comment->comment_img))
                    <p class="is-pulled-right "><a href="{{ asset('commentImages/'.$comment->comment_img) }}" download>Download<i class="fa fa-download" aria-hidden="true"></i></a></p>
                    <br>
                        <!-- Trigger the Modal -->
                        <img id="myImg" src="{{ asset('commentImages/'.$comment->comment_img) }}" alt="{{$comment->comment_text}}" onclick="
                            document.getElementById('myModal').style.display = 'block';
                            document.getElementById('img01').src = this.src;
                            document.getElementById('caption').innerHTML = this.alt;
                        ">

                        <!-- The Modal -->
                        <div id="myModal" class="modal">

                          <!-- The Close Button -->
                          <span class="close" onclick="
                            document.getElementById('myModal').style.display ='none';
                          ">&times;</span>

                          <!-- Modal Content (The Image) -->
                          <img class="modal-content" id="img01">

                          <!-- Modal Caption (Image Text) -->
                          <div id="caption"></div>
                        </div>
                    <br>
                @endif
                @php
                  $commentLikeNum = 0;
                  $commentDislikeNum = 0;
                  $commentUserLiked = false;
                  $commentUserDisliked = false;
                  foreach($comment->likes as $like){
                    if ($like->like == 1) {
                      if ($like->user_id == auth()->user()->id) {
                        $commentUserLiked = 1;
                      }
                      $commentLikeNum++;
                    }else{
                      if ($like->user_id == auth()->user()->id) {
                        $commentUserDisliked = 1;
                      }
                      $commentDislikeNum++;
                    }
                  }
                @endphp
                <like-comment-component token="{{csrf_token()}}" comment-id="{{$comment->id}}" user-comment-liked="{{$commentUserLiked}}" user-comment-disliked="{{$commentUserDisliked}}" post-id="{{$post->id}}" like-comment-count="{{$commentLikeNum}}" dislike-comment-count="{{$commentDislikeNum}}" comment-created-at = "{{$comment->created_at}}"></like-comment-component>
              </p>
              <p><i aria-hidden="true" class="fa fa-comments"></i> {{$comment->replyComment()->count()}} Replies</p>
            </div>
              @foreach($comment->replyComment as $reply)
                  <article class="media">
                    <figure class="media-left">
                      <p class="image is-48x48">
                        <a href="{{ route('user.show',$reply->user->name) }}"><img src="{{$reply->user->profile_img}}"></a>
                      </p>
                    </figure>
                    <div class="media-content">
                      <div class="content">
                        <p>
                          <strong><a href="{{ route('user.show',$reply->user->name) }}">{{$reply->user->name}}</a></strong>
                          @if ($reply->reply_id != 0)
                          @php
                            $replyToUser=ReplyComment::findOrFail($reply->reply_id);
                          @endphp
                            <small>To:</small>
                            <strong><a href="{{ route('user.show',$replyToUser->user->name) }}">{{$replyToUser->user->name}}</a></strong>  
                          @endif
                          <p class="comment_text_style">{{$reply->reply_comment_text}}</p>
                          @if($reply->reply_comment_img != null && !empty($reply->reply_comment_img))
                              <p class="is-pulled-right"><a href="{{ asset('commentImages/'.$reply->reply_comment_img) }}" download>Download<i class="fa fa-download" aria-hidden="true"></i></a></p>
                              <!-- Trigger the Modal -->
                              <img id="myImg" src="{{ asset('commentImages/'.$reply->reply_comment_img) }}" alt="{{$reply->reply_comment_text}}" onclick="
                                  document.getElementById('myModal').style.display = 'block';
                                  document.getElementById('img01').src = this.src;
                                  document.getElementById('caption').innerHTML = this.alt;
                              ">

                              <!-- The Modal -->
                              <div id="myModal" class="modal">

                                <!-- The Close Button -->
                                <span class="close" onclick="
                                  document.getElementById('myModal').style.display ='none';
                                ">&times;</span>
                                

                                <!-- Modal Content (The Image) -->
                                <img class="modal-content" id="img01">

                                <!-- Modal Caption (Image Text) -->
                                <div id="caption"></div>
                              </div>
                          @endif
                          @php
                            $replyLikeNum = 0;
                            $replyDislikeNum = 0;
                            $replyUserLiked = false;
                            $replyUserDisliked = false;
                            foreach($reply->likes as $like){
                              if ($like->like == 1) {
                                if ($like->user_id == auth()->user()->id) {
                                  $replyUserLiked = 1;
                                }
                                $replyLikeNum++;
                              }else{
                                if ($like->user_id == auth()->user()->id) {
                                  $replyUserDisliked = 1;
                                }
                                $replyDislikeNum++;
                              }
                            }
                          @endphp
                          <like-reply-component comment-id="{{$comment->id}}" token="{{csrf_token()}}" reply-created-at ="{{$reply->created_at}}" reply-id ="{{$reply->id}}" like-reply-count ="{{$replyLikeNum}}" dislike-reply-count="{{$replyDislikeNum}}" post-id ="{{$post->id}}" user-reply-liked ="{{$replyUserLiked}}" user-reply-disliked ="{{$replyUserDisliked}}" ></like-reply-component>
                        </p>
                      </div>
                    </div>
                  </article>
              @endforeach
          </div>
          {{-- Ovo he delete button
          <div class="media-right">
            <button class="delete"></button>
          </div> --}}
        </article>
    @endforeach
</div> 