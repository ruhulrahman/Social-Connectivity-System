@extends('profile.master')

@section('content')
<div class="container">
    <div class="row">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ URL::to('/home') }}">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Friend Requests</li>
          </ol>
        </nav>

        <div class="col-md-3">
            @include('profile.sidebar')
        </div>
        <div class="col-md-9">
            <div class="panel panel-primary">
                <div class="panel-heading ">Friends:
                    <?php
                       $countFnd = DB::table('friendships')
                            ->where('status', 1)
                            ->where('requester', '=', Auth::user()->id)
                            ->count();
                    ?>
                    @if ($countFnd)                        
                        ({{ $countFnd }})
                    @else
                        You don't any friend yet.
                    @endif

                </div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

 
                            @if (session()->has('msg'))
                                    <p class="alert alert-success">{{ session()->get('msg') }}</p>
                            @endif 
                    @foreach ($friends as $fnds)
                    <div class="">
                        <div class="col-md-12">                   
                            <div class="thumbnail text-center">
                                    <h4><a href="{{ url('/friendDetails/'.$fnds->id) }}">{{ $fnds->name }}</a></h4>
                                    <a href="{{ url('/friendDetails/'.$fnds->id) }}"><p><img src="{{ asset('img') }}/{{ $fnds->pic }}" alt="Image" width="100px" height="100px" class="img-circle"></p></a>           
                                        <p>Gender - {{ $fnds->gender }}</p>
                                        <p><i class="fa fa-glob"></i> {{ $fnds->city }}, {{ $fnds->country }}</p>

                                
                                        <a href="{{ url('/unfriend/'.$fnds->id) }}" class="btn btn-danger">Unfriend</a></p>
                            </div>
                        </div>
                    </div>
                    @endforeach

                    <div class="col-md-4">
{{--                         <h4><span class="label label-primary">City</span></h4>
                        <p>{{ $data->city }}</p

                        <h4><span class="label label-primary">Country</span></h4>
                        <p>{{ $data->country }}</p>

                        <h4><span class="label label-primary">About</span></h4>
                        <p>{{ $data->about }}</p> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
