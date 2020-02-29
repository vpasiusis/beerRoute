@extends('layouts.app')


@section('content')
<h1>Beer Route</h1>
{!! Form::open(array('action' => 'BeersController@store')) !!}
    <div class="form-group">
        {{Form::label('latitude','Latitude')}}
        {{Form::text('latitude','', ['class'=>'form-control','placeholder'=>'Lattitude'])}}
        {{Form::label('longitude','Longitute')}}
        {{Form::text('longitude','', ['class'=>'form-control','placeholder'=>'Longitute'])}}
   
    {{Form::submit('Search Route',['class'=>'btn btn-primary'])}}
{!! Form::close() !!}
        
@endsection