<?php
namespace App\Classes;

class Distances
{
    public function FormingMatrix($geoCodes)
    {
        $DistancesMatrix = array( );

        for ($col = 0; $col < count($geoCodes); $col++) {
            for ($col2 = 0; $col2 < count($geoCodes); $col2++) {
                $DistancesMatrix[$geoCodes[$col]->brewery_id][$geoCodes[$col2]->brewery_id]=$this->haversineGreatCircleDistance(
                    $geoCodes[$col]->latitude, $geoCodes[$col]->longitude,
                    $geoCodes[$col2]->latitude, $geoCodes[$col2]->longitude,
                    $earthRadius = 6371000);
            }
        }
        return $DistancesMatrix;
    }

    public function FirstPosibleBrewery($geoCodes,$latitude,$longitude)
    {
        $PosibleBrewery = array();

        for ($col = 0; $col < count($geoCodes); $col++) {
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