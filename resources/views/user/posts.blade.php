@extends('layouts.app')

@section('content')
    <div class="container">
          @if(Session::has('success'))
            <div class="notification is-primary">
                <button class="delete"></button>
                {{Session::get('success')}}
            </div>
          @endif
        <div class="columns is- is-marginless is-centered">
            <div class="column is-6">
                <nav class="card">
                    <header class="card-header">
                        <p class="card-header-title">
                            Post A Meme
                        </p>
                    </header>

                    @include('_includes._createPost')
                </nav>
            </div>
        </div>
        <p class="has-text-centered title is-3">Your Posts</p>
        <hr>{{-- End of creating a post --}}
        @php
            $posts = auth()->user()->posts()->orderByDesc('id')->paginate(30);
        @endphp

        @if($posts->count() == 0)
            <h1 class="title is-3 has-text-centered">You have no posts</h1>
        @endif

        @foreach($posts as $post)
            <div class="columns is- is-marginless is-centered">
                <div class="column is-5">
                    <nav class="card">
                        <header class="card-header">
                            <small>Created By: <a href="{{ route('user.show',$post->user->name) }}">{{$post->user->name}}</a></small>
                            <p class="card-header-title">
                                {{$post->post_text}}  
                            </p>
                            <small><a href="{{ asset('postImages/'.$post->post_img) }}" download>Download<i class="fa fa-download" aria-hidden="true"></i></a></small>
                        </header>
                        <div class="card-content">
                            <!-- Trigger the Modal -->
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
                            <a href="{{ route('post.edit',$post->id) }}" class="card-footer-item ">Edit</a>
                            <a href="#" onclick="event.preventDefault();document.getElementById('delete-post').submit();" class="card-footer-item">Delete</a>
                            <form id="delete-post" action="{{ route('post.destroy',$post->id) }}" method="POST"
                                  style="display: none;">
                                {{ csrf_field() }}
                                {{ method_field('DELETE') }}
                            </form>
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
                 
                    </nav>
                </div>       
            </div>
        @endforeach
       <div class="columns is- is-marginless is-centered">
            <div class="column is-5">
              {{$posts->links()}}
            </div>
        </div>

    </div>
@endsection

@section('script')
<script>
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#yourImage')
                    .attr('src', e.target.result)
                    //.width(150)
                    .height(200);
                $('#yourImage').show();
            };

            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@stop
