@extends('layouts.app')


@section('content')

    @if(count($finalArray)>0)
        <h2 class="card-title"> List of beers names({{$finalArray[100][3]}})</h2>
        @foreach ($finalArray as $final=>$value)
           @if($final==100)
         
           <h2 class="card-title">Distance traveled - {{$finalArray[$final][1]}}</h2>
           <h2 class="card-title">Algorithm time - {{$finalArray[$final][2]}}</h2>
           <h2 class="card-title">Visited Breweries({{count($finalArray[$final][0])}})</h2>
           @foreach ($finalArray[$final][0] as $brewerie)
           <p class="card-title">{{$brewerie->name}}</p>
           @endforeach
           @else
           
           
           @foreach ($finalArray[$final] as $object)
           
            <div class="card-block">
            <p class="card-title"> {{$object->name}}</p>
            </div>
            
            @endforeach

            @endif
         
        @endforeach
    @else
        <p>No routes found</p>
    @endif
    <a href ="/beerRoute/public/" type="button" class="btn btn-info">Back</a>

@endsection