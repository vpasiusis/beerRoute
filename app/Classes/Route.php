<?php
namespace App\Classes;

use App\Classes\BeerObject;
use App\Classes\Distances;
class Route
{
   
    public function CountingRoute($distanceMatrix,$breweriesArray,$startInd,$array,$countingArray)
    {
        if(count($countingArray)>count($array)){
            $array=$countingArray;
        }
        

    }
    public function Routes($distanceMatrix,$breweriesArray,$firstBrewery,$startLoc,$geoCodes)
    {
        $finalArray=[];
        $newArray=[];
        foreach($firstBrewery as $key=>$value) {
            $currentDistance=0;
            $countingArray=$breweriesArray[$key];
            $currentDistance=$this->addValue(0,$firstBrewery[$key],$key,$startLoc,$geoCodes);
            if($currentDistance!=-1){
                $newArray=$this->CountingRoute($distanceMatrix,$breweriesArray,$key,$finalArray,$countingArray);
            }
           # if(count($newArray)>count($finalArray)){
          #      $finalArray= $newArray;
           # }
         }
       
    }

    public function addValue($currentDistance,$travel,$brewery_id,$startLoc,$geoCodes){

        
        $distance=new Distances();
        $returnHome=$distance->haversineGreatCircleDistance(
            $geoCodes[$brewery_id][0], $geoCodes[$brewery_id][1], $startLoc->latitude,
            $startLoc->longitude, $earthRadius = 6371000);

        $newDistance=$currentDistance+$travel+$returnHome;
        if($newDistance<=2000){
            $newDistance=$newDistance-$returnHome;
            return $newDistance;
        }else{
            return -1;
        }
        


    }
}