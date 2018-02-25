@extends('profile.master')

@section('content')
<div class="container">
    <div class="row">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ URL::to('/home') }}">Home</a></li>
            <li class3="breadcrumb-item active" aria-current="page">Profile</li>
          </ol>
        </nav>

        <div class="col-md-3">
            @include('profile.sidebar')
        </div>
        <div class="col-md-9">
            <div class="panel panel-primary">
                <div class="panel-heading ">Welcome to you Profile Page</div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="col-md-4">                        
                        <div class="thumbnail text-center">
                            {{ Auth::user()->name }}
                            @if (Auth::user()->gender == 'male')                        
                                <p><img src="{{ asset('img') }}/{{ Auth::user()->pic }}" alt="Image" width="100px" height="100px" class="img-circle"></p>
                            @elseif (Auth::user()->gender == 'female')
                                <p><img src="{{ asset('img') }}/{{ Auth::user()->pic }}" alt="Image" width="100px" height="100px" class="img-circle"></p>
                            @endif
                            <p>{{ $data->city }}, {{ $data->country }}</p>
                            <a href="{{ URL::to('/changePhoto') }}" class="btn btn-primary">Change Profile</a>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <h4><span class="label label-primary">City</span></h4>
                        <p>{{ $data->city }}</p

                        <h4><span class="label label-primary">Country</span></h4>
                        <p>{{ $data->country }}</p>

                        <h4><span class="label label-primary">About</span></h4>
                        <p>{{ $data->about }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
