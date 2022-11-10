@extends('layouts.app')

@section('content')
	<div class="container">
		<div class="profile">
			<figure class="image profile_pic">
		      {{-- <img src="{{$user->profile_img}}" alt="Profile image"> --}}
		      <img id="myImg" src="{{$user->profile_img}}" alt="Profile image" onclick="
                                document.getElementById('myModal').style.display = 'block';
                                document.getElementById('img01').src = this.src;
                            ">

                            <!-- The Modal -->
                            <div id="myModal" class="modal">

                              <!-- The Close Button -->
                              <span class="close" onclick="
                                document.getElementById('myModal').style.display ='none';
                              ">&times;</span>

                              <!-- Modal Content (The Image) -->
                              <img class="modal-content" id="img01">
                            </div>
		    </figure>
		    <a class="profileButton" href="{{ route('user.userPosts',$user->name) }}">View All Posts</a>
		</div>
	</div>
@endsection