@extends('profile.master')

@section('content')
<div class="container">
    <div class="row">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ URL::to('/home') }}">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Find Friends</li>
          </ol>
        </nav>

        <div class="col-md-3">
            @include('profile.sidebar')
        </div>
        <div class="col-md-9">

                    @foreach ($allusers as $fnds)
            <div class="panel panel-primary">
                <div class="panel-heading ">Details of {{ $fnds->name }}</div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="">
                        <div class="col-md-12">                        
                            <div class="thumbnail text-center">
                                    <h4><a href="{{ url('/friendDetails/'.$fnds->id) }}">{{ $fnds->name }}</a></h4>
                                    <a href=""><p><img src="{{ asset('img') }}/{{ $fnds->pic }}" alt="Image" width="500px" height="500px" class="text-center"></p></a>
                                        <p>{{ $fnds->city }}</p>
                                        <p>{{ $fnds->country }}</p>
                                        <p>{{ $fnds->about }}</p>
                                <a href="{{ URL::to('/changePhoto') }}" class="btn btn-primary">Send Friend Request</a>
                            </div>
                        </div>
                    </div>
                    @endforeach

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
