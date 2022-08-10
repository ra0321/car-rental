<?php

namespace App\Models\Traits;

/**
 * Trait Mutators
 * @package App\Models\Traits
 */
trait Mutators
{
	/**
	 * @param $is_facebook
	 */
	public function setIsFacebookAttribute($is_facebook)
	{
		$this->attributes['is_facebook'] = $this->changeToBool($is_facebook);
	}

	/**
	 * @param $is_google
	 */
	public function setIsGoogleAttribute($is_google)
	{
		$this->attributes['is_google'] = $this->changeToBool($is_google);
	}

	/**
	 * @param $email_promotions
	 */
	public function setEmailPromotionsAttribute($email_promotions)
	{
		$this->attributes['email_promotions'] = $this->changeToBool($email_promotions);
	}

	/**
	 * @param $sms_notifications
	 */
	public function setSmsNotificationsAttribute($sms_notifications)
	{
		$this->attributes['sms_notifications'] = $this->changeToBool($sms_notifications);
	}

	/**
	 * @param $transmission_expert
	 */
	public function setTransmissionExpertAttribute($transmission_expert)
	{
		$this->attributes['transmission_expert'] = $this->changeToBool($transmission_expert);
	}

	/**
	 * @param $brended
	 */
	public function setBrendedAttribute($brended)
	{
		$this->attributes['brended'] = $this->changeToBool($brended);
	}

	/**
	 * @param $is_automatic_price
	 */
	public function setIsAutomaticPriceAttribute($is_automatic_price)
	{
		$this->attributes['is_automatic_price'] = $this->changeToBool($is_automatic_price);
	}

	/**
	 * @param $car_is_active
	 */
	public function setCarIsActiveAttribute($car_is_active)
	{
		$this->attributes['car_is_active'] = $this->changeToBool($car_is_active);
	}

	/**
	 * @param $hybrid
	 */
	public function setHybridAttribute($hybrid)
	{
		$this->attributes['hybrid'] = $this->changeToBool($hybrid);
	}

	/**
	 * @param $bike_rack
	 */
	public function setBikeRackAttribute($bike_rack)
	{
		$this->attributes['bike_rack'] = $this->changeToBool($bike_rack);
	}

	/**
	 * @param $all_drive
	 */
	public function setAllDriveAttribute($all_drive)
	{
		$this->attributes['all_drive'] = $this->changeToBool($all_drive);
	}

	/**
	 * @param $child_seat
	 */
	public function setChildSeatAttribute($child_seat)
	{
		$this->attributes['child_seat'] = $this->changeToBool($child_seat);
	}

	/**
	 * @param $gps
	 */
	public function setGpsAttribute($gps)
	{
		$this->attributes['gps'] = $this->changeToBool($gps);
	}

	/**
	 * @param $ski_rack
	 */
	public function setSkiRackAttribute($ski_rack)
	{
		$this->attributes['ski_rack'] = $this->changeToBool($ski_rack);
	}

	/**
	 * @param $bluetooth
	 */
	public function setBluetoothAttribute($bluetooth)
	{
		$this->attributes['bluetooth'] = $this->changeToBool($bluetooth);
	}

	/**
	 * @param $usb
	 */
	public function setUsbAttribute($usb)
	{
		$this->attributes['usb'] = $this->changeToBool($usb);
	}

	/**
	 * @param $ventilated_seat
	 */
	public function setVentilatedSeatAttribute($ventilated_seat)
	{
		$this->attributes['ventilated_seat'] = $this->changeToBool($ventilated_seat);
	}

	/**
	 * @param $audio_input
	 */
	public function setAudioInputAttribute($audio_input)
	{
		$this->attributes['audio_input'] = $this->changeToBool($audio_input);
	}

	/**
	 * @param $convertible
	 */
	public function setConvertibleAttribute($convertible)
	{
		$this->attributes['convertible'] = $this->changeToBool($convertible);
	}

	/**
	 * @param $toll_pass
	 */
	public function setTollPassAttribute($toll_pass)
	{
		$this->attributes['toll_pass'] = $this->changeToBool($toll_pass);
	}

	/**
	 * @param $sunroof
	 */
	public function setSunroofAttribute($sunroof)
	{
		$this->attributes['sunroof'] = $this->changeToBool($sunroof);
	}

	/**
	 * @param $pet_friendly
	 */
	public function setPetFriendlyAttribute($pet_friendly)
    {
        $this->attributes['pet_friendly'] = $this->changeToBool($pet_friendly);
    }

	/**
	 * @param $heated_seat
	 */
	public function setHeatedSeatAttribute($heated_seat)
    {
        $this->attributes['heated_seat'] = $this->changeToBool($heated_seat);
    }

	/**
	 * @param $have_no_car
	 */
	public function setHaveNoCarAttribute($have_no_car)
	{
		$this->attributes['have_no_car'] = $this->changeToBool($have_no_car);
	}

	/**
	 * @param $safety_concerns
	 */
	public function setSafetyConcernsAttribute($safety_concerns)
	{
		$this->attributes['safety_concerns'] = $this->changeToBool($safety_concerns);
	}

	/**
	 * @param $not_earning_enough
	 */
	public function setNotEarningEnoughAttribute($not_earning_enough)
	{
		$this->attributes['not_earning_enough'] = $this->changeToBool($not_earning_enough);
	}

	/**
	 * @param $other_reason
	 */
	public function setOtherReasonAttribute($other_reason)
	{
		$this->attributes['other_reason'] = $this->changeToBool($other_reason);
	}

	/**
	 * @param $too_much_work
	 */
	public function setTooMuchWorkAttribute($too_much_work)
	{
		$this->attributes['too_much_work'] = $this->changeToBool($too_much_work);
	}

	/**
	 * @param $negative_experience
	 */
	public function setNegativeExperienceAttribute($negative_experience)
	{
		$this->attributes['negative_experience'] = $this->changeToBool($negative_experience);
	}

	/**
	 * @param $on_car_location
	 */
	public function setOnCarLocationAttribute($on_car_location)
	{
		$this->attributes['on_car_location'] = $this->changeToBool($on_car_location);
	}

	/**
	 * @param $on_airport
	 */
	public function setOnAirportAttribute($on_airport)
	{
		$this->attributes['on_airport'] = $this->changeToBool($on_airport);
	}

    /**
     * @param $long_term_trip
     */
    public function setLongTermTripAttribute($long_term_trip)
    {
        $this->attributes['long_term_trip'] = $this->changeToBool($long_term_trip);
    }

    /**
     * @param $weekend_trip
     */
    public function setWeekendTripAttribute($weekend_trip)
    {
        $this->attributes['weekend_trip'] = $this->changeToBool($weekend_trip);
    }

	/**
	 * @param $division
	 *
	 * @return string
	 */
	public function getDivisionAttribute($division)
	{
		return strtoupper($division);
	}

    /**
     * @param $i_agree
     */
    public function setIAgreeAttribute($i_agree)
    {
        $this->attributes['i_agree'] = $this->changeToBool($i_agree);
    }

    /**
     * @param $work_on_airport
     */
    public function setWorkOnAirportAttribute($work_on_airport)
    {
        $this->attributes['work_on_airport'] = $this->changeToBool($work_on_airport);
    }

	/**
	 * @param $work_on_guest_location
	 */
	public function setWorkOnGuestLocationAttribute($work_on_guest_location)
    {
        $this->attributes['work_on_guest_location'] = $this->changeToBool($work_on_guest_location);
    }

    /**
     * @param $on_guest_location
     */
    public function setOnGuestLocationAttribute($on_guest_location)
    {
        $this->attributes['on_guest_location'] = $this->changeToBool($on_guest_location);
    }

	/**
	 * @param $inappropriate
	 */
	public function setInappropriateAttribute($inappropriate)
    {
        $this->attributes['inappropriate'] = $this->changeToBool($inappropriate);
    }

	/**
	 * @param $misleading
	 */
	public function setMisleadingAttribute($misleading)
    {
        $this->attributes['misleading'] = $this->changeToBool($misleading);
    }

	/**
	 * @param $spam
	 */
	public function setSpamAttribute($spam)
    {
        $this->attributes['spam'] = $this->changeToBool($spam);
    }

	/**
	 * @param $other
	 */
	public function setOtherAttribute($other)
    {
        $this->attributes['other'] = $this->changeToBool($other);
    }

	/**
	 * @param $promotions
	 */
	public function setPromotionsAttribute($promotions)
    {
        $this->attributes['promotions'] = $this->changeToBool($promotions);
    }

	/**
	 * @param $unavailable
	 */
	public function setUnavailableAttribute($unavailable)
    {
        $this->attributes['unavailable'] = $this->changeToBool($unavailable);
    }

	/**
	 * @param $repair
	 */
	public function setRepairAttribute($repair)
    {
        $this->attributes['repair'] = $this->changeToBool($repair);
    }

	/**
	 * @param $guest_cancel
	 */
	public function setGuestCancelAttribute($guest_cancel)
    {
        $this->attributes['guest_cancel'] = $this->changeToBool($guest_cancel);
    }

	/**
	 * @param $uncomfortable
	 */
	public function setUncomfortableAttribute($uncomfortable)
    {
        $this->attributes['uncomfortable'] = $this->changeToBool($uncomfortable);
    }

	/**
	 * @param $pick_on_airport
	 */
	public function setPickOnAirportAttribute($pick_on_airport)
    {
        $this->attributes['pick_on_airport'] = $this->changeToBool($pick_on_airport);
    }

	/**
	 * @param $pick_on_car_location
	 */
	public function setPickOnCarLocationAttribute($pick_on_car_location)
    {
        $this->attributes['pick_on_car_location'] = $this->changeToBool($pick_on_car_location);
    }

	/**
	 * @param $pick_on_guest_location
	 */
	public function setPickOnGuestLocationAttribute($pick_on_guest_location)
    {
        $this->attributes['pick_on_guest_location'] = $this->changeToBool($pick_on_guest_location);
    }

	/**
	 * @param $value
	 *
	 * @return bool
	 */
	public function changeToBool($value)
	{
		if($value === "true" || $value === true || $value === 1){
			$newValue = true;
			return $newValue;
		}
		if($value === "false" || $value === false || $value === 0){
			$newValue = false;
			return $newValue;
		}
		return false;
	}
}