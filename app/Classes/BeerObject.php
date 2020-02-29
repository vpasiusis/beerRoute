<?php
namespace App\Classes;
/**
 * Object of beer, out of these objects the breweries list is made
 */
class BeerObject
{

    public $name;
    public $categorie;
    public $style;
    
    function __construct($name,$categorie,$style) {
        $this->name = $name;
        $this->categorie = $categorie;
        $this->style = $style;
    } 


    
}