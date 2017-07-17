@extends('layouts.main')
@section('content')

    <h1>User list</h1>
    @if(count($users) > 0)
        <ul class="list-group">
            @foreach($users as $user)
                <li class="list-group-item">
                    <a href="{{url('user/' . $user->id)}}">
                        <strong>{{$user->name}}</strong>: {{$user->twitter_id}} / {{$user->screen_name}}
                    </a>
                </li>
            @endforeach
        </ul>
    @endif

@stop
