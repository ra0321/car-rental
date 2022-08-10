<?php

namespace App\Traits;


/**
 * Trait Distances
 * @package App\Traits
 */
trait Distances
{
    /**
     * @param $fromPoint
     * @param $toPoint
     * @return float
     */
    public function locationDistances($fromPoint, $toPoint)
    {
        $theta = $fromPoint['long_location'] - $toPoint['longitude'];
        $dist = sin($this->degToRad($fromPoint['lat_location'])) * sin($this->degToRad($toPoint['latitude'])) +  cos($this->degToRad($fromPoint['lat_location'])) * cos($this->degToRad($toPoint['latitude'])) * cos($this->degToRad($theta));
        $dist = acos($dist);
        $dist = $this->radToDeg($dist);
        $miles = $dist * 60 * 1.1515;
        $meter = $miles * 1.609;
        return $meter;
    }

    /**
     * @param $deg
     * @return float|int
     */
    public function degToRad($deg)
    {
        $rad = $deg * M_PI / 180;
        return $rad;
    }

    /**
     * @param $rad
     * @return float|int
     */
    public function radToDeg($rad)
    {
        $deg = $rad * 180 / M_PI;
        return $deg;
    }
}