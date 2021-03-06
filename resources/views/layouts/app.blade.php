<?php
use App\Course;
?>
<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
    <script src="https://www.promisejs.org/polyfills/promise-6.1.0.js"></script>
    <link rel="stylesheet" href="https://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.css">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/jquery.slick/1.6.0/slick.css"/>
    <script type="text/javascript" src="//cdn.jsdelivr.net/jquery.slick/1.6.0/slick.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-default navbar-static-top">
            <div class="container">
                <div class="navbar-header">

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">
                        &nbsp;
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->
                        @if (Auth::guest())
                            <li><a href="{{ url('/') }}">Login</a></li>
                            <li><a href="{{ route('register') }}">Register</a></li>
                        @else
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    Hi! {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu" role="menu">
                                    <li>
                                        <a href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            Logout
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        <li style="border:1px solid #2ca02c;color:#2ca02c;padding:5px 10px;margin-top:8px;border-radius: 8px;">
                                {{ Auth::user()->position }}
                        </li>
                        @endif
                    </ul>
                </div>
            </div>
        </nav>

        @yield('content')
    </div>

    <!-- Scripts -->
    @yield('script')
    <script src="{{ asset('js/app.js') }}"></script>
    <script>
        var token = '{{ Session::token() }}';
        var urlLike = '{{ route('understand') }}';
        $('.js-like-button').on('click', function(evt) {
            evt.preventDefault();
            var $btn = $(this);
            var liked = ($btn.text().match(' Cancel Request') === null);
            var topicId = evt.target.parentNode.dataset['topicid'];
            console.log(liked);
            $.ajax({
                method: 'POST',
                url:urlLike,
                data:{liked:liked,topicId:topicId,_token:token}
            })
                .done(function(){
                });
            $btn.html('<img class="like-btn__spinner" src="http://jxnblk.com/loading/loading-bars.svg" alt="loading"/> Saving');
                if (liked) {
                    $btn.html('<img src="/img/question-green.png" style="height: 20px"/>︎&nbsp; Cancel Request');
                } else {
                    $btn.html('<img src="/img/question-green.png" style="height: 20px"/>︎&nbsp; I don\'t understand');
                }

        });
    </script>
    <script>
        var token = '{{ Session::token() }}';
        var urlLike = '{{ route('understandMsg') }}';
        $('.understandimg').on('click', function(evt) {
            evt.preventDefault();
            var $btn = $(this);
            //$('.key').attr('src','/img/key.png')
            var liked = ($btn.attr("src") === '/img/ques-red.png');
            var messageId = evt.target.parentNode.parentNode.dataset['messageid'];
            console.log(liked);
            $.ajax({
                method: 'POST',
                url:urlLike,
                data:{liked:liked,messageId:messageId,_token:token}
            })
                .done(function(){
                });
            if (liked) {
                $btn.attr('src','/img/ques-black.png');
            } else {
                $btn.attr('src','/img/ques-red.png');
            }

        });
    </script>
</body>
</html>
