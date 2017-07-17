@extends('layouts.main')
@section('content')

    <h1>User: {{$user->name}}</h1>

    <ul class="list-group">
        @foreach($tweets as $tweet)
            <li class="list-group-item">
                {{$tweet->text}}
            </li>
        @endforeach
    </ul>

@stop
