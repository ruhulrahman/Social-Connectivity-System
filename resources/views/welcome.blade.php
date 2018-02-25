<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

        <link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #ddd;
                color:#2b2b2b;
                margin: 0;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 12px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }
        </style>

    </head>
    <body>
        <div id="app">
        <div class="">
            @if (Route::has('login'))
                <div class="top-right links">
                    @if (Auth::check())
                        <a href="{{ url('/home') }}">Home</a>
                        <a href="{{ url('/profile') }}/{{ Auth::user()->slug }}">Profile</a>
                    @else
                        <a href="{{ url('/login') }}">Login</a>
                        <a href="{{ url('/register') }}">Register</a>
                    @endif
                </div>
            @endif

            <div class="container" style="background: #FFF; margin-top: 50px;">
                <div class="row">
                    <div class="col-lg-4"></div>
                    <div class="col-lg-8">                        
                    @{{ msg }} <small style="color: green">@{{ content }}</small>
                    <form method="post" enctype="multipart/form-data" v-on:submit.prevent="addPost">
                        <textarea cols="90" rows="5" v-model="content"></textarea>
                        <button type="submit" class="btn btn-success">Submit</button>
                    </form>
                    </div>
                    
                </div>

                @foreach ($posts as $pst)
                    <div class="col-lg-12">
                        <div class="col-lg-2 pull-left">
                            <img src="{{ asset('img') }}/{{ $pst->pic }}" alt="Image" style="width: 100px; height: 100px; margin: 10px">
                        </div>
                        <div class="col-lg-10">
                            <h3><a href="{{ url('/profile') }}/{{ $pst->slug }}">{{ $pst->name }}</a></h3>
                            <p><i class="fas fa-map-marker"></i> {{ $pst->city }}, {{ $pst->country }}</p>
                            <p><i class="fas fa-clock"></i> {{ date('F j, Y', strtotime($pst->created_at)) }} at {{ date('H:i a', strtotime($pst->created_at)) }}</p>
                        </div>
                    </div>
                    <p class="col-lg-12" style="padding:10px 0px; border-bottom: 1px solid #ddd">
                        {{ $pst->posts }}
                    </p>
                @endforeach
            </div>

        </div>
        </div>


        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}"></script>
    </body>
</html>
