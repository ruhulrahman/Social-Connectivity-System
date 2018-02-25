@extends('profile.master')

@section('content')
<div class="container">
    <div class="row">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ URL::to('/home') }}">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Notifications</li>
          </ol>
        </nav>

        <div class="col-md-3">
            @include('profile.sidebar')
        </div>
        <div class="col-md-9">
            <div class="panel panel-primary">
                <div class="panel-heading ">Notifications</div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="row">

                        @foreach ($notifications as $fnds)

                        <div class="text-left">
                            <div class="col-md-3">                
                                <h4><a href="{{ url('/friendDetails/'.$fnds->id) }}">{{ $fnds->name }}</a></h4>
                                <a href="{{ url('/friendDetails/'.$fnds->id) }}"><p><img src="{{ asset('img') }}/{{ $fnds->pic }}" alt="Image" width="100px" height="100px" class="img-circle"></p></a>           
                                <p>Gender - {{ $fnds->gender }}</p>
                            </div>
                            <div class="col-md-9">                    
                                <p><i class="fa fa-glob"></i> {{ $fnds->city }}, {{ $fnds->country }}</p>
                            </div>
                        </div>

                         @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
