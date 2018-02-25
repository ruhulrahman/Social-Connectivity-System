@extends('profile.master')



@section('content')
<div class="container">
    <div class="row">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ URL::to('/home') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ URL::to('/profile') }}/{{ Auth::user()->slug }}">Profile</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit Profile</li>
          </ol>
        </nav>
        <div class="col-md-3">
            @include('profile.sidebar')
        </div>
        <div class="col-md-9">
            <div class="panel panel-primary">
                <div class="panel-heading">Update Your Profile</div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                        <div class="thumbnail text-center">
                            {{ Auth::user()->name }}                       
                                <p><img src="{{ asset('img') }}/{{ Auth::user()->pic }}" alt="Image" width="200px" height="200px" class="img-thumbnail"></p>
                            <p>{{ $data->city }}, {{ $data->country }}</p>
                            <a href="{{ URL::to('/changePhoto') }}" class="btn btn-primary">Change Profile</a>
                        </div>

                    <form action="{{ URL::to('/updateProfile') }}" method="post">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                      <div class="form-group">
                        <label for="city">City Name</label>
                        <input type="text" name="city" value="{{ $data->city }}" class="form-control" id="city" aria-describedby="cityHelp" placeholder="Enter city name">
                      </div>
                      <div class="form-group">
                        <label for="country">Country Name</label>
                        <input type="text" name="country" value="{{ $data->country }}" class="form-control" id="country" aria-describedby="countryHelp" placeholder="Enter country name">
                      </div>
                      <div class="form-group">
                        <label for="about">About</label>
                        <textarea name="about" class="form-control" id="about">{{ $data->about }}</textarea>
                      </div>
                      <input type="submit" value="Save Update" class="btn btn-primary">
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
