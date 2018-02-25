@extends('profile.master')

@section('content')
<div class="container">
    <div class="row">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ URL::to('/home') }}">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Change Photo</li>
          </ol>
        </nav>
        <div class="col-md-3">
            @include('profile.sidebar')
        </div>
        <div class="col-md-9">
            <div class="panel panel-primary">
                <div class="panel-heading">{{ Auth::user()->name }}</div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    Upload your new photo
                    @if (Auth::user()->gender == 'male')                        
                        <p><img src="{{ asset('img') }}/{{ Auth::user()->pic }}" alt="Image" width="100px" height="100px"   ></p>
                    @elseif (Auth::user()->gender == 'female')
                        <p><img src="{{ asset('img') }}/{{ Auth::user()->pic }}" alt="Image" width="100px" height="100px"></p>
                    @endif
                    <form action="{{ URL::to('/uploadPhoto') }}" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="file" class="form-control-file" id="photo" name="pic">
                        <input type="submit" value="submit" class="btn btn-success">
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
