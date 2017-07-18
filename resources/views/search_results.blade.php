@extends('layouts.main')
@section('content')

        <ul class="list-group">
            @foreach($tweets as $tweet)
                <li class="list-group-item">
                    <strong>{{$tweet->user->name}}</strong>: {{$tweet->text}}
                </li>
            @endforeach
        </ul>

        {{$tweets->render()}}

@stop