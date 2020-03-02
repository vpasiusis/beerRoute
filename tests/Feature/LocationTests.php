<?php

namespace Tests\Feature;

use Illuminate\Http\Request;
use Tests\TestCase;
use App\Http\Controllers\BeersController;

class LocationTests extends TestCase
{

   
    /** @test */
    public function location_latitude_is_required()
    {

        $request = Request::create('/beers', 'POST',[
            'latitude'     =>     '54.451816',
            'longitude'     =>     '',
        ]);


        $controller = new BeersController();
        $response = $controller->validates($request);
        $this->assertEquals(true, $response->fails());
    }
     
    /** @test */
    public function location_latitude_has_to_be_coordinate()
    {

        $request = Request::create('/beers', 'POST',[
            'latitude'     =>      '5',
            'longitude'     =>     '51.742503',
        ]);


        $controller = new BeersController();
        $response = $controller->validates($request);
        $this->assertEquals(true, $response->fails());
    }
    /** @test */
    public function location_accepted()
    {

        $request = Request::create('/beers', 'POST',[
            'latitude'     =>      '51.742503',
            'longitude'     =>     '11.100790',
        ]);


        $controller = new BeersController();
        $response = $controller->validates($request);
        $this->assertEquals(false, $response->fails());
    }
}