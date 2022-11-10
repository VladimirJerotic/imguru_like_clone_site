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
        <p class="has-text-centered title is-3">Your Liked Posts</p>
        <hr>{{-- End of creating a post --}}
    @if($posts->count() == 0)
        <h1 class="title is-3 has-text-centered">You have no liked posts</h1>
    @endif

    @foreach($posts as $post)
        @include('_includes._showPosts')
    @endforeach

   <div class="columns is- is-marginless is-centered">
    <div class="column is-5">
      {{$likes->links()}}
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