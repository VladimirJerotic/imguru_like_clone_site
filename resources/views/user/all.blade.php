@extends('layouts.app')

@section('content')
    <div class="container">
          @if(Session::has('success'))
            <div class="notification is-primary">
                <button class="delete"></button>
                {{Session::get('success')}}
            </div>
          @endif

          @foreach($users as $user)
          <div class="columns is- is-marginless is-centered">
            <div class="column is-8">
              <div class="box">
                <article class="media">
                  <div class="media-left">
                    <figure class="image is-64x64">
                      <a href="{{ route('user.show',$user->name) }}"><img src="{{$user->profile_img}}" alt="Profile Image"></a>
                    </figure>
                  </div>
                  <div class="media-content">
                    <div class="content">
                      <p>
                        <strong>{{$user->name}}</strong>
                        <br>
                        <a href="{{ route('user.show',$user->name) }}">View Profile</a>
                      </p>
                    </div>
                  </div>
                </article>
              </div>
            </div>
          </div>
          @endforeach
          <div class="columns is- is-marginless is-centered">
              <div class="column is-5">
                {{$users->links()}}
              </div>
          </div>
        </div>
@endsection
