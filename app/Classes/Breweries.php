<?php
namespace App\Classes;

use App\Classes\BeerObject;

class Breweries
{
   public function FormingDraweries($beers,$geoCodes){
       $DraweriesArray=array();
       for ($col = 0; $col < count($beers); $col++) {
            $object=new BeerObject($beers[$col]->name,$beers[$col]->cat_id,$beers[$col]->style_id);
            if($this->checkIfDataExists($geoCodes,$beers[$col]->brewery_id)){
                $DraweriesArray[$beers[$col]->brewery_id][] = $object;
            }
        }
        return $DraweriesArray;
   }

   public function checkIfDataExists($geoCodes,$id){
        foreach($geoCodes as $geoCode){
            if($geoCode->brewery_id==$id){
                return true;
            }
        }
        return false;

   }
   public function checkIftypeExist($beers,$selectedBeers)
   {
       
       $beers=$this->checkType($beers);
       $count=0;
       foreach($beers as $beer){
        
           foreach($selectedBeers as $selected){
                if($beer->categorie==-1){
                    break;
                }
                foreach($selected as $select){
                    if($select->categorie ==$beer->categorie 
                    and $select->style ==$beer->style)
                    {
                        unset($beers[$count]);
                        break;
                    }
                }
        }
        $count=$count+1;
      }
      $beers = array_values($beers);
      return $beers;
   }
   public function checkType($beers)
   {
      
       foreach($beers as $key=>$value){
            for($start=$key+1;$start<count($beers);$start++){
                
                if($beers[$start]->categorie ==$beers[$key]->categorie 
                and $beers[$start]->style ==$beers[$key]->style)
                {
                    unset($beers[$start]);
                    $beers = array_values($beers);
                }
            }
            
        }
        return $beers;
   }
   public function gettingBreweriesNames($ids,$breweries){
    $BreweriesArray=array();

    foreach($ids as $id){
        foreach($breweries as $brewerie){
            if($id==$brewerie->id){
                array_push($BreweriesArray,$brewerie);
            }
        }
    }
    return $BreweriesArray;
    }
}
