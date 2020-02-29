<?php
namespace App\Classes;

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