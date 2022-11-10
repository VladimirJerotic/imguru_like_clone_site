<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" class="has-navbar-fixed-top">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Memes Garden</title>
        <link rel="shortcut icon" href="{{ asset('images/Memes.ico') }}" type="image/x-icon" /> 

        <!-- Styles -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        @yield('style')
    </head>
    <body>
        <div id="app">
            <nav class="navbar has-shadow is-fixed-top">
                <div class="container">
                    <div class="navbar-brand">
                        @if(auth()->check())
                            <a href="{{ route('home.index') }}" class="navbar-item">
                                <img src="{{ asset('images/Memes.png') }}" alt="Logo">
                            </a>
                            <div class="is-hidden-desktop" id="some"><notification-component></notification-component></div>
                        @endif
                        <div id="meniOmotac" class="navbar-burger burger" data-target="navMenu">
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                    </div>
                    <div class="navbar-menu" id="navMenu">
                        <div class="navbar-start"></div>

                        <div class="navbar-end">
                            @if (Auth::guest())
                                <a class="navbar-item " href="{{ route('login') }}">Login</a>
                                <a class="navbar-item " href="{{ route('register') }}">Register</a>
                            @else
                                <div class="is-hidden-touch"><notification-component></notification-component></div>
                                <div class="navbar-item has-dropdown is-hoverable">
                                    <a class="navbar-link" href="#">{{ Auth::user()->name }}</a>

                                    <div class="navbar-dropdown">
                                        <a class="navbar-item {{ Nav::isRoute('home.index') }}" href="{{ route('home.index') }}">Home</a>
                                        <a class="navbar-item {{ Nav::isRoute('user.all') }}" href="{{ route('user.all') }}">All Users</a>
                                        <a class="navbar-item {{ Nav::isRoute('user.posts') }}" href="{{ route('user.posts') }}">Your Posts</a>
                                        <a class="navbar-item {{ Nav::isRoute('user.likedPosts') }}" href="{{ route('user.likedPosts') }}">Liked Posts</a>
                                        <a class="navbar-item" href="{{ route('logout') }}"
                                           onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                            Logout
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                              style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                </div>
            </nav>
            {{-- Success Message For All Pages --}}
            @yield('content')
        </div>

        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}"></script>
        @yield('script')
    </body>
</html>
