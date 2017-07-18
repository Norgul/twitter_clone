@extends('layouts.main')
@section('content')

    {{Form::open(['url' => 'search/tweets'])}}

    <div class="col-lg-6 col-md-6">
        <div class="form-group">
            <label for="text">Tweet</label>
            {{ Form::text('text', null,['class' => 'form-control']) }}
        </div>
    </div>

    <div class="col-lg-6 col-md-6">
        <div class="form-group">
            <label for="user_id">Select user</label>
            {!! Form::select('user_id', $users, 'Select user',['class' => 'form-control']) !!}
        </div>
    </div>

    <div class="col-lg-12 col-md-12">
        <button type="submit" class="btn btn-default">Submit</button>
    </div>

    {{Form::close()}}

@stop