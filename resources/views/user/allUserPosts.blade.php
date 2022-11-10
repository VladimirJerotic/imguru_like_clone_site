@extends('layouts.app')

@section('content')
<div class="container">
    @if($posts->count() == 0)
        <h1 class="title is-3 has-text-centered">This User Has No Posts</h1>
    @endif

    @foreach($posts as $post)
        @include('_includes._showPosts')
    @endforeach

   <div class="columns is- is-marginless is-centered">
            <div class="column is-5">
              {{$posts->links()}}
            </div>
        </div>

@endsection
</div>