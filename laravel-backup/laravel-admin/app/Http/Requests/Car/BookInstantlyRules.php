<?php

namespace App\Http\Requests\Car;

use App\Exceptions\CustomException;
use App\Rules\RealBool;
use App\Traits\ValueTransform;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * Class BookInstantlyRules
 * @package App\Http\Requests\Car
 */
class BookInstantlyRules extends FormRequest
{
    use ValueTransform;
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * @return array
     * @throws CustomException
     */
    public function rules()
    {
        $short_trip = $this->shortestTrip($this->request->get('short_trip'));
        $long_trip = $this->longestTrip($this->request->get('long_trip'));
        if($short_trip > $long_trip){
            throw new CustomException(SHORTEST_TRIP_MUST_BE_SHORTER_THAN_LONGEST_TRIP);
        }
        return [
	        'on_car_location' => [new RealBool(ON_CAR_LOCATION)],
	        'on_airport' => [new RealBool(ON_AIRPORT)],
	        'on_guest_location' => [new RealBool(ON_GUEST_LOCATION)],
	        'weekend_trip' => [new RealBool(WEEKEND_TRIP)],
	        'long_term_trip' => [new RealBool(LONG_TERM_TRIP)],
            'adv_notice' => Rule::in(['1 hour', '2 hours', '3 hours', '6 hours', '12 hours', '1 day', '2 days', '3 days', '1 week']),
            'short_trip' => Rule::in(['Any', '1 day', '2 days', '3 days', '5 days', '1 week', '2 weeks', '1 month']),
            'long_trip' => Rule::in(['3 days', '5 days', '1 week', '2 weeks', '1 month', '3 months', 'Any']),
	        /*'car_location_notice' => Rule::in(['1 hour', '2 hours', '3 hours', '6 hours', '12 hours', '1 day', '2 days', '3 days', '1 week']),
            'airport_notice' => Rule::in(['1 hour', '2 hours', '3 hours', '6 hours', '12 hours', '1 day', '2 days', '3 days', '1 week']),
            'guest_location_notice' => Rule::in(['1 hour', '2 hours', '3 hours', '6 hours', '12 hours', '1 day', '2 days', '3 days', '1 week']),*/
        ];
    }
}
