<?php
namespace App\Classes;
/**
 * Object for location
 */
class Location
{

    public $latitude;
    public $longitude;
    
    function __construct($latitude,$longitude) {
        $this->latitude = $latitude;
        $this->longitude = $longitude;
    } 
}