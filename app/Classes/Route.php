<?php
namespace App\Classes;

use App\Classes\Breweries;
use App\Classes\Distances;
class Route
{
   
    public function CountingRoute($distanceMatrix,$breweriesArray,$start,$array,
    $countingArray,$geoCodes,$cur_distance,$startLoc,$breweries_id,$key,$visited,$marked)
    {
        $brewery=new Breweries();
        if($key>=1223){
            if($this->typesCount($countingArray)>$this->typesCount($array)){
                $array=$countingArray;
                $array[100]=[$visited,$cur_distance];
                return $array;
            }
            return;
        }
        if(in_array($breweries_id[$key], $marked))
        {
            return $this->CountingRoute($distanceMatrix,$breweriesArray,$breweries_id[$key],$array,
            $countingArray,$geoCodes,$cur_distance,$startLoc,$breweries_id,$key=$key+1,$visited,$marked);
        }
       
        if($this->addValue($cur_distance,$distanceMatrix[$start][$breweries_id[$key]],
        $breweries_id[$key],$startLoc,$geoCodes)!=-1){
            $marked[]=$breweries_id[$key];
            $filteredBeers=$brewery->checkIftypeExist($breweriesArray[$breweries_id[$key]],$countingArray);
            if(count($filteredBeers)!=0){
                $visited[]=$breweries_id[$key];
                $cur_distance=$this->addValue($cur_distance,$distanceMatrix[$start][$breweries_id[$key]],
                $breweries_id[$key],$startLoc,$geoCodes);
                $countingArray[]=$filteredBeers;
                return $this->CountingRoute($distanceMatrix,$breweriesArray,$breweries_id[$key],$array,
                $countingArray,$geoCodes,$cur_distance,$startLoc,$breweries_id,0,$visited,$marked);
            }
        }
        return  $this->CountingRoute($distanceMatrix,$breweriesArray,$start,$array,
        $countingArray,$geoCodes,$cur_distance,$startLoc,$breweries_id,$key=$key+1,$visited,$marked);
        
      
        
       
    }
    public function Routes($distanceMatrix,$breweriesArray,$firstBrewery,$startLoc,$geoCodes)
    {
        $brew=new Breweries();
        $distance=new Distances();
        $finalArray=[];
        $breweries_id=$this->getBreweriesId($breweriesArray);
        $start = microtime(true);
        foreach($firstBrewery as $key=>$value) {
            $newArray=[];
            $visited=[];
            $marked=[];
            $currentDistance=0;
            $countingArray[]=$brew->checkType($breweriesArray[$key]);
            $currentDistance=$this->addValue(0,$firstBrewery[$key],$key,$startLoc,$geoCodes);
            if($currentDistance!=-1){
                $newArray=$this->CountingRoute($distanceMatrix,$breweriesArray,$key,$finalArray,
                $countingArray,$geoCodes,$currentDistance,$startLoc,$breweries_id,0,$visited,$marked);
            }
            if($newArray!=NULL){
                if($this->typesCount($newArray)>$this->typesCount($finalArray)){
                    $finalArray= $newArray;
                }
            }
            $countingArray=[];
        }
        $comingHome=$distance->haversineGreatCircleDistance(
            $geoCodes[end($finalArray[100][0])][0], $geoCodes[end($finalArray[100][0])][1],
            $startLoc->latitude,$startLoc->longitude, $earthRadius = 6371000);
        
        $finalArray[100][1]+=$comingHome;
        $finalArray[100][2] = microtime(true) - $start;
        return $finalArray;
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

    public function getBreweriesId($breweries){
        $brewerie_id=[];
        foreach($breweries as $key=>$value){
            $brewerie_id[]=$key;
        }
        return $brewerie_id;
    }

    public function typesCount($array)
    {
        $count=0;
        foreach($array as $arraySecond){
           foreach($arraySecond as $arrayThird){
                $count=$count+1;
           }
       }

       return $count;
    }
}