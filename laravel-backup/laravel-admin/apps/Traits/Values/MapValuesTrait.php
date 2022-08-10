<?php


namespace App\Traits\Values;


use App\BookInstantly;
use App\CarAirport;

/**
 * Trait MapValuesTrait
 * @package App\Traits\Values
 */
trait MapValuesTrait
{

    /**
     * @var array
     */
    static $trueArray = ['true', true, 1];

    /**
     * @param $trip
     * @param $data
     */
    public function newTripMapValues(&$trip, $data)
    {
        $trip['delivery_on_airport'] = filter_var($data['pick_on_airport'], FILTER_VALIDATE_BOOLEAN) ? true : false;
        $trip['delivery_on_car_location'] = filter_var($data['pick_on_car_location'], FILTER_VALIDATE_BOOLEAN) ? true : false;
        $trip['delivery_on_renter_location'] = filter_var($data['pick_on_guest_location'], FILTER_VALIDATE_BOOLEAN) ? true : false;
        $trip['renter_confirm_trip'] = 'confirmed';
        $trip['status'] = 'waiting';
        $trip['i_agree'] = $data['i_agree'];
        $trip['start_date'] = $data['price_from_date'];
        $trip['end_date'] = $data['price_until_date'];
    }

    /**
     * @param $trip
     * @param $data
     */
    public function mapDeliveryLocation(&$trip, $data)
    {
        $booked = BookInstantly::whereCarId($data['car']->id)->firstOrFail();
        if (filter_var($data['pick_on_airport'], FILTER_VALIDATE_BOOLEAN)) {
            $airport = CarAirport::findOrFail($data['airport_id']);
            $trip['airport_id'] = $data['airport_id'];
            $trip['long_location'] = $airport->longitude;
            $trip['lat_location'] = $airport->latitude;
            $trip['booked_instantly'] = (bool)$booked->on_airport;
            $trip['notice_time'] = $data['car']->airport_notice === null ? $data['car']->notice : $data['car']->airport_notice;
            $trip['pickup_location'] = $airport->airport_city;
        }
        if (filter_var($data['pick_on_car_location'], FILTER_VALIDATE_BOOLEAN)) {
            $trip['long_location'] = $data['car']->long_location;
            $trip['lat_location'] = $data['car']->lat_location;
            $trip['booked_instantly'] = (bool)$booked->on_car_location;
            $trip['notice_time'] = $data['car']->car_location_notice === null ? $data['car']->notice : $data['car']->car_location_notice;
            $trip['pickup_location'] = $data['car']->car_city;
        }
        if (filter_var($data['pick_on_guest_location'], FILTER_VALIDATE_BOOLEAN)) {
            $trip['long_location'] = $data['long_location'];
            $trip['lat_location'] = $data['lat_location'];
            $trip['booked_instantly'] = (bool)$booked->on_guest_location;
            $trip['notice_time'] = $data['car']->guest_location_notice === null ? $data['car']->notice : $data['car']->guest_location_notice;
            $trip['pickup_location'] = $data['car']->car_city;
        }
        $trip['owner_confirm_trip'] = filter_var($trip['booked_instantly'], FILTER_VALIDATE_BOOLEAN) ? 'confirmed' : 'waiting';
    }

    public function updateTripMapValues($data)
    {
        $data['price_from_date'] = isset($data['price_from_date']) ? $data['price_from_date'] : $data['trip']->start_date;
        $data['price_until_date'] = isset($data['price_until_date']) ? $data['price_until_date'] : $data['trip']->end_date;
        $data['pick_on_airport'] = isset($data['pick_on_airport']) ? $data['user']->changeToBool($data['pick_on_airport']) : $data['trip']->delivery_on_airport;
        $data['airport_id'] = isset($data['airport_id']) ? $data['airport_id'] : $data['trip']->airport_id;
        $data['pick_on_car_location'] = isset($data['pick_on_car_location']) ? $data['user']->changeToBool($data['pick_on_car_location']) : $data['trip']->delivery_on_car_location;
        $data['pick_on_guest_location'] = isset($data['pick_on_guest_location']) ? $data['user']->changeToBool($data['pick_on_guest_location']) : $data['trip']->delivery_on_renter_location;
        $data['long_location'] = isset($data['long_location']) ? $data['long_location'] : $data['car']->long_location;
        $data['lat_location'] = isset($data['lat_location']) ? $data['lat_location'] : $data['car']->lat_location;
        $data['message'] = isset($data['message']) ? $data['message'] : null;

        if($data['airport_id']){
            $airport = CarAirport::findOrFail($data['airport_id']);
            $data['long_location'] = $airport->longitude;
            $data['lat_location'] = $airport->latitude;
        }
        if(isset($data['long_location']) && isset($data['lat_location'])){
            $data['airport_id'] = null;
        }
        return $data;
    }
}
