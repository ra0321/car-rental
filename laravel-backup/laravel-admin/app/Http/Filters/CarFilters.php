<?php

namespace App\Http\Filters;

/**
 * Class CarFilters
 * @package App\Http\Filters
 */
class CarFilters extends QueryFilter
{
    /**
     * @return mixed
     */
    public function hybrid()
    {
        return $this->builder->whereHas('carFeature', function ($query){
            $query->where('hybrid', true);
        });
    }

    /**
     * @return mixed
     */
    public function bike()
    {
        return $this->builder->whereHas('carFeature', function ($query){
            $query->where('bike_rack', true);
        });
    }

    /**
     * @return mixed
     */
    public function drive()
    {
        return $this->builder->whereHas('carFeature', function ($query){
            $query->where('all_drive', true);
        });
    }

    /**
     * @return mixed
     */
    public function childSeat()
    {
        return $this->builder->whereHas('carFeature', function ($query){
            $query->where('child_seat', true);
        });
    }

    /**
     * @return mixed
     */
    public function gps()
    {
        return $this->builder->whereHas('carFeature', function ($query){
            $query->where('gps', true);
        });
    }

    /**
     * @return mixed
     */
    public function skiRack()
    {
        return $this->builder->whereHas('carFeature', function ($query){
            $query->where('ski_rack', true);
        });
    }

    /**
     * @return mixed
     */
    public function bluetooth()
    {
        return $this->builder->whereHas('carFeature', function ($query){
            $query->where('bluetooth', true);
        });
    }

    /**
     * @return mixed
     */
    public function usb()
    {
        return $this->builder->whereHas('carFeature', function ($query){
            $query->where('usb', true);
        });
    }

    /**
     * @return mixed
     */
    public function ventilatedSeat()
    {
        return $this->builder->whereHas('carFeature', function ($query){
            $query->where('ventilated_seat', true);
        });
    }

    /**
     * @return mixed
     */
    public function audioInput()
    {
        return $this->builder->whereHas('carFeature', function ($query){
            $query->where('audio_input', true);
        });
    }

    /**
     * @return mixed
     */
    public function convertible()
    {
        return $this->builder->whereHas('carFeature', function ($query){
            $query->where('convertible', true);
        });
    }

    /**
     * @return mixed
     */
    public function sunroof()
    {
        return $this->builder->whereHas('carFeature', function ($query){
            $query->where('sunroof', true);
        });
    }

    /**
     * @return mixed
     */
    public function tollPass()
    {
        return $this->builder->whereHas('carFeature', function ($query){
            $query->where('toll_pass', true);
        });
    }

	/**
	 * @return mixed
	 */
	public function petFriendly()
    {
    	return $this->builder->whereHas('carFeature', function($query){
		    $query->where('pet_friendly', true);
	    });
    }

	/**
	 * @return mixed
	 */
	public function heatedSeat()
	{
		return $this->builder->whereHas('carFeature', function ($query){
			$query->where('heated_seat', true);
		});
	}

    /**
     * @param $manufacturer
     * @return mixed
     */
    public function manufacturer($manufacturer)
    {
        return $this->builder->where('car_manufacturer', $manufacturer);
    }

    /**
     * @param $minYear
     * @return mixed
     */
    public function minYear($minYear)
    {
        return $this->builder->where('production_year', '>=', $minYear);
    }

    /**
     * @param $maxYear
     * @return mixed
     */
    public function maxYear($maxYear)
    {
        return $this->builder->where('production_year', '<=', $maxYear);
    }

    /**
     * @param $transmission
     * @return mixed
     */
    public function transmission($transmission)
    {
        return $this->builder->where('car_transmission', $transmission);
    }

    /**
     * @param $category
     * @return mixed
     */
    public function category($category)
    {
        return $this->builder->where('model_class', $category);
    }

    /**
     * @return mixed
     */
    public function bookInstantly()
    {
        return $this->builder->whereHas('bookInstantly', function ($query){
            $query->where('on_car_location', true)
                ->orWhere('on_airport', true)
                ->orWhere('on_guest_location', true);
        });
    }

    /**
     * @return mixed
     */
    public function delivery()
    {
        return $this->builder->whereHas('bookInstantly', function ($query){
            $query->where('work_on_guest_location', true);
        });

	    /*return $this->builder->whereHas('bookInstantly', function ($query){
		    $query->where('work_on_guest_location', true);
	    })->orWhereHas('carAirport', function($query){
		    $query->where('work_on_airport', true);
	    });*/
    }

    /**
     * @param $vehicleType
     * @return mixed
     */
    public function vehicleType($vehicleType)
    {
        $types = explode(',', $vehicleType);
        return $this->builder->whereIn('vehicle_type', $types);
    }

    /**
     * @param $color
     * @return mixed
     */
    public function color($color){
        $colors = explode(',', $color);
        return $this->builder->whereHas('carFeature', function ($query) use ($colors){
            $query->whereIn('color', $colors);
        });
    }

}
