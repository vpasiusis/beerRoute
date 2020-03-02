<?php
namespace App\Classes;

use App\Classes\Breweries;
use App\Classes\Distances;
class Route
{
    

     /**
     * Method visits all breweries from given first one
     *
     * @param   ArrayMatrix  $distanceMatrix  
     * @param   ArrayBreweries  $breweriesArray  
     * @param   Int  $start   CurrentIdOfBrewery
     * @param   ArrayBreweries  $array    FinalArray
     * @param   ArrayBreweries  $countingArray
     * @param   geoCodesArray  $geoCodes  
     * @param   double  $cur_distance    current distance travelled
     * @param   Location  $startLoc      Location of start
     * @param   breweriesIdArray  $breweries_id   
     * @param   breweriesId  $key       current brewery id
     * @param   breweriesIdArray  $visited   all Visited Breweries
     * @param   breweriesIdArray  $marked    breweries which is visited or rejected
     *
     * @return  ArrayBreweries        closes recursion, or returns Array of visited breweries
     */
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
   /**
    * Method select which route is better
    *
    * @param   MatrixArray  $distanceMatrix  
    * @param   ArrayOfbreweries  $breweriesArray  
    * @param   ArrayOfDistance  $firstBrewery    Posible first bwereries distances
    * @param   Location  $startLoc        starting Location
    * @param   geoCodesArray  $geoCodes       
    *
    * @return  ArrayOfBreweriesAndBeers     FinalArray with routes               
    */
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
                /**
                 * Goes to CountingRoute for every possible firstChoice brewery
                 *
                 * @var [type]
                 */
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
        
        $finalArray[100][1] += $comingHome;
        $finalArray[100][2] = microtime(true) - $start;
        $finalArray[100][3] = $this->typesCount($finalArray);
        return $finalArray;
    }
    /**
     * Method add value to current distance and checks if it possible to travel to given brewery
     *
     * @param   double  $currentDistance  
     * @param   double  $travel           Km to brewery
     * @param   int  $brewery_id          Id of next brewery
     * @param   Location  $startLoc       
     * @param   ArrayOfgeoCodes  $geoCodes  
     *
     * @return  double/int   if distance is not over limit return newDistance, if not return -1
     */
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
    /**
     * Method created array of breweries ids
     *
     * @param   ArrayOfBreweries  $breweries  
     *
     * @return  ArrayOfBreweriesIds    
     */
    public function getBreweriesId($breweries){
        $brewerie_id=[];
        foreach($breweries as $key=>$value){
            $brewerie_id[]=$key;
        }
        return $brewerie_id;
    }
    /**
     * Method counts how many types of beers given array has
     *
     * @param   ArrayOfBreweries  $array 
     *
     * @return  int    number of beer types
     */
    public function typesCount($array)
    {
      
        $count=0;
        foreach($array as $arraySecond=>$value){
            if($arraySecond==100){
            break;
            }
            foreach($array[$arraySecond] as $arrayThird){
                $count=$count+1;
           }
       }

       return $count;
    }
}