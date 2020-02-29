<?php
namespace App\Classes;

class Distances
{
    /**
     * Method forms distances matrix for all breweries   
     *
     * @param   [array of geoCoordinates]  $geoCodes  
     *
     * @return  arrayMatrix  Distances between breweries
     */
    public function FormingMatrix($geoCodes)
    {
        $DistancesMatrix = array( );

        foreach($geoCodes as $col=>$value) {
            foreach($geoCodes as $col2=>$value2) {
                $DistancesMatrix[$geoCodes[$col]->brewery_id][$geoCodes[$col2]->brewery_id]=$this->haversineGreatCircleDistance(
                    $geoCodes[$col]->latitude, $geoCodes[$col]->longitude,
                    $geoCodes[$col2]->latitude, $geoCodes[$col2]->longitude,
                    $earthRadius = 6371000);
            }
        }
        return $DistancesMatrix;
    }
    /**
     * Reform geoCodes that id would be breweryId
     *
     * @param   GeoCodesArray  $geoCodes  
     *
     * @return  GeoCodesArray       Reformed GeoCodesArray
     */
    public function formGeoCodes($geoCodes){
        $newGeoCodes=[];
        foreach($geoCodes as $col=>$value) {
            $newGeoCodes[$geoCodes[$col]->brewery_id]=[$geoCodes[$col]->latitude,$geoCodes[$col]->longitude];
        }
        return $newGeoCodes;
    }
    /**
     * Select only possible first brewery array
     *
     * @param   GeoCodesArray  $geoCodes   
     * @param   decimal  $latitude   StartingLatitude
     * @param   decimal  $longitude  StartingLongitute
     *
     * @return  ArrayOfDistances      FirstPossibleChoiceDistances
     */
    public function FirstPosibleBrewery($geoCodes,$latitude,$longitude)
    {
        $PosibleBrewery = array();

        foreach($geoCodes as $col=>$value){
            $distance=$this->haversineGreatCircleDistance(
                $geoCodes[$col]->latitude, $geoCodes[$col]->longitude,
                $latitude,$longitude,
                $earthRadius = 6371000);
           if($distance<=1000){
                $PosibleBrewery[$geoCodes[$col]->brewery_id]=$distance;
            }
    
        }
        return $PosibleBrewery;
    }
    /**
     * Method removes geoCoordinate if data doesn't exist
     *
     * @param   geoCodesArray  $geoCodes   
     * @param   breweriesArray $breweries  
     *
     * @return  geoCodesArray  Filtered geoCodes
     */
    public function removeUnusedBreweries($geoCodes,$breweries){
        
        foreach($geoCodes as $key2=>$value2) {
            $used=false;
            foreach($breweries as $key=>$value){
                if($key==$geoCodes[$key2]->brewery_id){
                    $used=true;
                break;
                }
            }
            if($used!=true){
                unset($geoCodes[$key2]);
                $used=false;
            }
        }
        return $geoCodes;
    }


    /**
     * Calculates the great-circle distance between two points, with
     * the Haversine formula.
     * @param float $latitudeFrom Latitude of start point in [deg decimal]
     * @param float $longitudeFrom Longitude of start point in [deg decimal]
     * @param float $latitudeTo Latitude of target point in [deg decimal]
     * @param float $longitudeTo Longitude of target point in [deg decimal]
     * @param float $earthRadius Mean earth radius in [m]
     * @return float Distance between points in [m] (same as earthRadius)
     */
    function haversineGreatCircleDistance(
    $latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo, $earthRadius = 6371000)
    { 

    // convert from degrees to radians
        $latFrom = deg2rad($latitudeFrom);
        $lonFrom = deg2rad($longitudeFrom);
        $latTo = deg2rad($latitudeTo);
        $lonTo = deg2rad($longitudeTo);

        $latDelta = $latTo - $latFrom;
        $lonDelta = $lonTo - $lonFrom;

        $angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) +
        cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)));
        return $angle * $earthRadius/1000;
    }
}