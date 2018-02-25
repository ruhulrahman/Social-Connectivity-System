<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">

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

                    <!-- Branding Image -->
                    <a class="navbar-brand" href="{{ url('/') }}">
                        {{ config('app.name', 'Laravel') }} 
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">
                        @if (Auth::check())
                            <li><a href="{{ url('/home') }}">Home</a></li>
                            <li><a href="{{ url('/profile') }}/{{ Auth::user()->slug }}">Profile</a></li>
                            <li><a href="{{ url('/findFriends') }}">Find Friends</a></li>
                            <li><a href="{{ url('/requests') }}">
                              Friend Requests <span class="badge badge-light" style="background: red">{{ App\Friendships::where('status', 0)->where('user_request', Auth::user()->id)->count() }}</span>
                                </a>
                            </li>
                        @endif
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->
                        @if (Auth::guest())
                            <li><a href="{{ route('login') }}">Login</a></li>
                            <li><a href="{{ route('register') }}">Register</a></li>
                        @else
                            <li>
                                <a href="{{ url('/friendList') }}"><i class="fas fa-users fa-2x"></i>
                                </a>
                            </li>
                            <li>
                                <?php 
                                    $count = DB::table('notifications')
                                    ->where('user_hero', Auth::user()->id)
                                    ->where('status', 1)
                                    ->count();
                                ?>
                                <a href="{{ url('/notifications') }}" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fas fa-globe fa-2x"></i>
                                    @if ($count)
                                    <span class="badge badge-light" style="background: red; position: relative; top: -15px; left: -10px;">   
                                        {{ $count }}
                                    </span>
                                    @endif
                                </a>
                                <?php
                                    $notifications = DB::table('users')
                                            ->leftJoin('notifications', 'users.id', 'notifications.user_logged')
                                            ->where('notifications.user_hero', Auth::user()->id)
                                            ->where('status', 1)
                                            ->orderBy('notifications.id','DESC')
                                            ->get();
                                ?>

                                <ul class="dropdown-menu" role="menu" style="width: 340px">
                                @foreach ($notifications as $notif)          
                                    <li><a href="{{ url('/notifications') }}/{{ $notif->id }}">
                                        <img src="{{ asset('img') }}/{{ $notif->pic }}" alt="Image" width="50px" height="50px">
                                        <b style="color: green; font-size: 90%">{{ ucwords($notif->name) }}</b> <span style="font-size: 90%">Acccepted your fnd request</span>
                                        <p><small>Time: {{ date('F j, Y', strtotime($notif->created_at)) }} at {{ date('H:i a', strtotime($notif->created_at)) }}</small></p>
                                        </a>
                                    </li>
                                @endforeach
                                </ul>
                            </li>
                            <li><a href=""><img src="{{ asset('img') }}/{{ Auth::user()->pic }}" width="30px" height="30px" alt="" class="img-circle" /></a></li>
                            <li class="dropdown">
                                
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    {{ ucwords(Auth::user()->name) }} <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu" role="menu">
                                    <li><a href="{{ url('/profile') }}/{{ Auth::user()->slug }}">Profile</a></li>
                                    <li>
                                        <a href="{{ URL::to('/editProfile') }}">
                                            Edit Profile
                                        </a>
                                    </li>
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
                        @endif
                    </ul>
                </div>
            </div>
        </nav>

        @yield('content')
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
