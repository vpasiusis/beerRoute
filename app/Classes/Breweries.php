<?php
namespace App\Classes;

use App\Classes\BeerObject;

class Breweries
{
   public function FormingDraweries($beers){
       $DraweriesArray=array();
       for ($col = 0; $col < count($beers); $col++) {
            $object=new BeerObject($beers[$col]->name,$beers[$col]->cat_id,$beers[$col]->style_id);
            $DraweriesArray[$beers[$col]->brewery_id][] = $object;
        }
        return $DraweriesArray;
   }
}
