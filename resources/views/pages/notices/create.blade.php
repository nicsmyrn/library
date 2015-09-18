@extends('app')

@section('content')
    <h1 class="page-heading">Prepare a DMCA notice</h1>

    @include('errors.list')

    {!! Form::open(['method'=>'GET', 'action'=>'NoticesController@confirm']) !!}
    
        <!-- Provider_id Form Input -->
        <div class="form-group" id="">
            {!! Form::label('provider_id', 'Provider_id:', ['class'=>'control-label']) !!}
            {!! Form::select('provider_id',$providers,null, ['class'=>'form-control']) !!}
        </div>

        <!-- Infringing_title Form Input -->
        <div class="form-group" id="">
            {!! Form::label('infringing_title', 'Infringing_title:', ['class'=>'control-label']) !!}
            {!! Form::text('infringing_title',null, ['class'=>'form-control']) !!}
        </div>

        <!-- Infringing_link Form Input -->
        <div class="form-group" id="">
            {!! Form::label('infringing_link', 'Infringing_link:', ['class'=>'control-label']) !!}
            {!! Form::text('infringing_link',null, ['class'=>'form-control']) !!}
        </div>

        <!-- Original_link Form Input -->
        <div class="form-group" id="">
            {!! Form::label('original_link', 'Original_link:', ['class'=>'control-label']) !!}
            {!! Form::text('original_link',null, ['class'=>'form-control']) !!}
        </div>

        <!-- Original_description Form Input -->
        <div class="form-group" id="">
            {!! Form::label('original_description', 'Original_description:', ['class'=>'control-label']) !!}
            {!! Form::text('original_description',null, ['class'=>'form-control']) !!}
        </div>

        <!-- Proview Notice Form Input -->
        <div class="form-group">
            {!! Form::submit('Proview Notice', ['class'=>'btn btn-primary form-control']) !!}
        </div>

    {!! Form::close() !!}
@endsection