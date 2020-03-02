<?php

namespace Tests\Feature;

use Illuminate\Http\Request;
use Tests\TestCase;
use App\Http\Controllers\BeersController;
use App\Classes\Route;

class RouteClassTests extends TestCase
{

    /** @test */
    public function check_counting_types()
    {
        $controller = new Route();
        $response = $controller->typesCount($this->Data());
        $this->assertEquals(8, $response);
    }

    public function Data(){

        $beerArray=array(
            array(
                array("Wiesen Edel Weisse","4","50"),
                array("Weisse","4","50")
            ),
            array(
                array("Wiesen Edel Weisse","4","50"),
                array("Weisse","4","50"),
                array("Wiesen Edel Weisse","4","50"),
                array("Weisse","4","50")
            ),
            array(
                array("Wiesen Edel Weisse","4","50")
            ),
            array(
                array("Weisse","4","50")
            )
        );

        return $beerArray;
    }
    
}