<?php
namespace App\Classes;

use App\Classes\BeerObject;

class Breweries
{
    /**
     * Method makes array of breweries with all of their beers
     *
     * @param   [beer data]  $beers     
     * @param   [geoCodes data]  $geoCodes  
     *
     * @return  array   Array of all breweries which have geoCoordinates
     */
   public function FormingBreweries($beers,$geoCodes){
       $DraweriesArray=array();
       for ($col = 0; $col < count($beers); $col++) {
            $object=new BeerObject($beers[$col]->name,$beers[$col]->cat_id,$beers[$col]->style_id);
            if($this->checkIfDataExists($geoCodes,$beers[$col]->brewery_id)){
                $DraweriesArray[$beers[$col]->brewery_id][] = $object;
            }
        }
        return $DraweriesArray;
   }

   /**
    * Method checks if brewery has geoCoordinate in database
    *
    * @param   [geoCodes object]  geoCodes  
    * @param   [int]  $id        [id of brewery]
    *
    * @return  boolean 
    */
   public function checkIfDataExists($geoCodes,$id){
        foreach($geoCodes as $geoCode){
            if($geoCode->brewery_id==$id){
                return true;
            }
        }
        return false;

   }
   /**
    * Method checks if current brewery has any types of beers already selected
    *
    * @param   [array of beersObjects]  $beers          [current brewery beers]
    * @param   [array of beersObjects]  $selectedBeers  [already selected beers]
    *
    * @return  array of beerObjects     Filtered beers types
    */
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
   /**
    * Method checks if brewery has same beer types, if yes removes them
    *
    * @param   [arrayOfBeerObjects]  $beers  [Brewery beers]
    *
    * @return  arrayOfBeerObjects    Filtered beers array
    */
   public function checkType($beers)
   {
      
      for($key=0;$key<count($beers);$key++){
            for($start=$key+1;$start<count($beers);$start++){
                if($beers[$start]->categorie ==$beers[$key]->categorie 
                and $beers[$start]->style ==$beers[$key]->style)
                {
                    unset($beers[$key]);
                    break;
                }
            }
            
        }
        $beers = array_values($beers);
        return $beers;
   }


   /**
    * Method gets breweries objects from $ids
    *
    * @param   [array int]  $ids        [breweries ids]
    * @param   [array of breweries]  $breweries  [breweries objects]
    *
    * @return  arrayofBreweries   
    */
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
