@extends('app')

@section('content')

    <h1 class="page-heading">Prepare a DMCA Notice</h1>

    {!! Form::open(['method' => 'GET', 'action' => 'NoticesController@confirm']) !!}

        <div class="form-group">
            {!! Form::label('provider_id', 'Who are we sending this to?') !!}
            {!! Form::select('provider_id', $providers, null, ['class' => 'form-control']) !!}
        </div>

        <div class="form-group">
            {!! Form::label('infringing_title', 'Infringing Title:') !!}
            {!! Form::text('infringing_title', null, ['class' => 'form-control']) !!}
        </div>

        <div class="form-group">
            {!! Form::label('infringing_link', 'Infringing Link:') !!}
            {!! Form::text('infringing_link', null, ['class' => 'form-control']) !!}
        </div>

        <div class="form-group">
            {!! Form::label('original_link', 'Original Link:') !!}
            {!! Form::text('original_link', null, ['class' => 'form-control']) !!}
        </div>

        <div class="form-group">
            {!! Form::label('original_description', 'Original Description:') !!}
            {!! Form::textarea('original_description', null, ['class' => 'form-control']) !!}
        </div>

        {!! Form::submit('Preview Notice', ['class' => 'btn btn-primary form-control']) !!}

    {!! Form::close() !!}

    @include('errors.list')

@endsection