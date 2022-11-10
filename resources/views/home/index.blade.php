@extends('layouts.app')

@section('content')
    <div class="container">
          @if(Session::has('success'))
            <div class="notification is-primary">
                <button class="delete"></button>
                {{Session::get('success')}}
            </div>
          @endif
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
        <p class="has-text-centered title is-3">Newest Posts</p>
        <hr>{{-- End of creating a post --}}
        @foreach($posts as $post)
             @include('_includes._showPosts')
        @endforeach
        <div class="columns is- is-marginless is-centered">
            <div class="column is-8">
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
