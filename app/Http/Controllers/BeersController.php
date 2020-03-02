<?php

namespace App\Http\Controllers;

use App\Beer;
use Illuminate\Http\Request;
use Validator;
use DB;
use App\Classes\Distances;
use App\Classes\Breweries;
use App\Classes\Location;
use App\Classes\Route;

class BeersController extends Controller
{
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($startLocation)
    {   
       
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       
        if ($this->validates($request)->fails()) {
            return redirect('/')->with('success','Post Created');
        } else {
            $finalArray=$this->dataProcessing(new Location($request->input('latitude'),$request->input('longitude')));
           return view('beer.index')-> with('finalArray',$finalArray);
        }
        
    }

    public function validates(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'latitude' => ['required','regex:/^[-]?(([0-8]?[0-9])\.(\d+))|(90(\.0+)?)$/'], 
            'longitude' => ['required','regex:/^[-]?((((1[0-7][0-9])|([0-9]?[0-9]))\.(\d+))|180(\.0+)?)$/']
        ]);


        return $validator;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    /** 
     * Method who proccess all the data and selects best route
     *
     * @param   Location  $startLocation  
     *
     * @return  ArrayOfSelectedBeersAndVisitedBreweries
     */
    public function dataProcessing($startLocation)
    {
        $distances = new Distances();
        $breweries = new Breweries();
        $route = new Route();
        $geoCodes=DB::table('geocodes')->get();
        $breweriesList=DB::table('breweries')->get();
        $beers = Beer::all();
        $breweriesArray=$breweries->FormingBreweries($beers,$geoCodes);
        $geoCodes=$distances->removeUnusedBreweries($geoCodes,$breweriesArray);
        $distanceMatrix=$distances->FormingMatrix($geoCodes);
        $firstBrewery=$distances->FirstPosibleBrewery($geoCodes,$startLocation->latitude,$startLocation->longitude);
        $newgeoCodes=$distances->formGeoCodes($geoCodes);
        $finalArray=$route->Routes($distanceMatrix,$breweriesArray,$firstBrewery,$startLocation,$newgeoCodes);
        $finalArray[100][0]=$breweries->gettingBreweriesNames($finalArray[100][0],$breweriesList);
        return $finalArray;
    }
}
