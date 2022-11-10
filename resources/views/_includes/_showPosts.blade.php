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
                <a href="{{ route('post.show',$post->id) }}" class="card-footer-item"><i class="fa fa-comments" aria-hidden="true"></i>{{$post->comments->count()}} Show Comments</a>
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