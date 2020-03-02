<?php

namespace Tests\Feature;

use Illuminate\Http\Request;
use Tests\TestCase;
use App\Http\Controllers\BeersController;
use App\Classes\Breweries;
use App\Classes\BeerObject;

class BreweriesClassTests extends TestCase
{

    /** @test */
    
    public function check_counting_types()
    {
        $controller = new Breweries();
        $response = $controller->checkType($this->Data());
        $this->assertEquals($this->FilteredbeersData(), $response);
    }
     /** @test */
     public function check_selected_counting_types()
     {
         $controller = new Breweries();
         $response = $controller->checkIftypeExist($this->Datas(),$this->DataForFilteringSelectedBeers());
         $this->assertEquals($this->DataSelectedFiltered(), $response);
     }

    public function Data(){
        $beerArray=array(
            array(
                new BeerObject("Wiesen Edel Weisse",4,5),
                new BeerObject("Aventinus Weizenstarkbier / Doppel Weizen Bock", 4,55),
                new BeerObject( "Weisse Dunkel", -1,-1),
                new BeerObject("St. Martin Doppelbock" , 7,90)
            )
        );
        return $beerArray;
    }
    public function FilteredbeersData(){
        $beerArray=array(
            array(
                new BeerObject("Wiesen Edel Weisse",4,5),
                new BeerObject("Schneider Weisse", 4,55),
                new BeerObject( "Weisse Dunkel", -1,-1),
                new BeerObject("St. Martin Doppelbock" , 7,90)
            )
        );
        return $beerArray;
    }

    public function DataForFilteringSelectedBeers(){
        $beerArray=array(
            array(
                new BeerObject("Wiesen Edel Weisse",4,5),
            )
        );
        return $beerArray;
    }

    public function DataSelectedFiltered(){
        $beerArray=array(
            array()
        );
        return $beerArray;
    }


    public function Datas(){
        $beerArray=array(
            array(
                new BeerObject("Wiesen Edel Weisse",4,5),
            ),
            array(
                new BeerObject("Schneider Weisse", 4,55),
                new BeerObject( "Weisse Dunkel", -1,-1),
            ),
            array(
                new BeerObject("St. Martin Doppelbock" , 7,90)
            )
        );
        return $beerArray;
    }
}