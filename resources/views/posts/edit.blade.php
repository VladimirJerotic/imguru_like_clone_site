@extends('layouts.app')

@section('content')
  <div class="container">
    @if(Session::has('success'))
        <div class="notification is-primary">
            <button class="delete"></button>
            {{Session::get('success')}}
        </div>
    @endif
    @if ($errors->has('comment_text'))
        <p class="help is-danger">
            {{ $errors->first('comment_text') }}
        </p>
    @endif
    @if ($errors->has('reply_comment_text'))
        <p class="help is-danger">
            {{ $errors->first('reply_comment_text') }}
        </p>
    @endif
    <div class="columns is- is-marginless is-centered">
        <div class="column is-5">
            <nav class="card" id="app">
                <form class="control" action="{{ route('post.update', $post->id) }}" method="POST" enctype="multipart/form-data">
                    {{csrf_field()}}
                    {{ method_field('PUT') }}
                    <header class="card-header">
                        <p class="card-header-title">
                            <input class="input" name="post_text" type="text" value="{{$post->post_text}}" placeholder="Title text">
                        </p>
                        <div class="field">
                          <label class="label"></label>
                          <div class="control">
                            <div class="file">
                              <label class="file-label">
                                <input class="file-input" accept="image/*" type="file" name="post_img">
                                <span class="file-cta" id="UpdateImg">
                                  <span class="file-icon">
                                    <i class="fa fa-upload" aria-hidden="true"></i>
                                  </span>
                                  <span class="file-label">
                                    Choose a image…
                                  </span>
                                </span>
                              </label>
                            </div>
                          </div>
                        </div>
                    </header>
                    <div class="card-content">
                        <img id="myImg" src="{{ asset('postImages/'.$post->post_img) }}" alt="{{$post->post_text}}" onclick="
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
                    </div>
                    <footer class="card-footer">
                        <input type="submit" value="Update" class="card-footer-item" id="UpdateButton">
                        <a href="{{ route('post.show',$post->id) }}" class="card-footer-item" id="CancleButton">Cancel</a>
                    </footer>
                  @php
                  $likeNum = 0;
                  $dislikeNum = 0;
                  $userLiked = false;
                  $userDisliked = false;
                  foreach($post->likes as $like){
                    if ($like->like == 1) {
                      if ($like->user_id == auth()->user()->id) {
                        $userLiked = 1;
                      }
                      $likeNum++;
                    }else{
                      if ($like->user_id == auth()->user()->id) {
                        $userDisliked = 1;
                      }
                      $dislikeNum++;
                    }
                  }
                @endphp
                <like-component user-liked="{{$userLiked}}" user-disliked="{{$userDisliked}}" post-id="{{$post->id}}" like-count="{{$likeNum}}" dislike-count="{{$dislikeNum}}"></like-component> 
                </form>
            </nav>

            @if ($errors->has('post_text'))
                <p class="help is-danger">
                    {{ $errors->first('post_text') }}
                </p>
            @endif
            @if ($errors->has('post_img'))
                <p class="help is-danger">
                    {{ $errors->first('post_img') }}
                </p>
            @endif

            <div class="field">
              <form class="control" action="{{ route('comment.store') }}" method="post" enctype="multipart/form-data">
                {{csrf_field()}}
                <label for="comment_text" class="title is-3">Comment:</label>
                <input class="input is-rounded" id="comment_text" name="comment_text" type="text" placeholder="Comment ...">
                <div class="field">
                  <label class="label">Img</label>
                  <div class="control">
                    <div class="file">
                      <label class="file-label">
                        <input class="file-input" accept="image/*" type="file" name="comment_img">
                        <span class="file-cta">
                          <span class="file-icon">
                            <i class="fa fa-upload" aria-hidden="true"></i>
                          </span>
                          <span class="file-label">
                            Choose  image…
                          </span>
                        </span>
                      </label>
                    </div>
                  </div>
                </div>
                <input type="hidden" name="post_id" value="{{$post->id}}">
                <input type="submit" value="Comment" class="button is-primary pull-right is-rounded btn-block">
              </form>
            </div>
            @include('_includes._comments')
        </div>
    </div>
  </div> 
@endsection