@extends('frontend.app')

@section('title')
    Δοκιμαστική Σελίδα
@stop

@section('content')
    <!-- Username Form Input -->
    <div class="form-group">
        {!! Form::label('username', 'Username:') !!}
        {!! Form::text('username',null, ['class'=>'form-control']) !!}
    </div>

    <!-- Password Form password -->
    <div class="form-group">
        {!! Form::label('password', 'Password:') !!}
        {!! Form::password('password', ['class'=>'form-control']) !!}
    </div>

@endsection

