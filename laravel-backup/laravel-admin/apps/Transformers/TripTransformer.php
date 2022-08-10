<?php

namespace App\Transformers;

use App\Chat;
use App\Trip;
use App\User;
use DB;
use League\Fractal\TransformerAbstract;

/**
 * Class TripTransformer
 * @package App\Transformers
 */
class TripTransformer extends TransformerAbstract
{
    /**
     * @var array
     */
    protected $defaultIncludes = [
        'tripBill', 'car', 'chat', 'review'
    ];

	/**
	 * @param Trip $trip
	 *
	 * @return array
	 */
	public function transform(Trip $trip)
    {
        if($trip->delivery_on_airport){
            $airport = DB::table('esar_airports')
                ->where('latitude', $trip->lat_location)
                ->where('longitude', $trip->long_location)
                ->first();
        }
        $owner = User::findOrFail($trip->owner_id);
        $renter = User::findOrFail($trip->renter_id);

        return [
            'tripId' => (int)$trip->id,
            'chatId' => (int)$trip->chat_id,
	        'carRenter' => (int)$trip->renter_id,
            'carRenterFirstName' => (string)$renter->first_name,
            'carRenterLastName' => (string)$renter->last_name,
	        'carOwner' => (int)$trip->owner_id,
            'carOwnerFirstName' => (string)$owner->first_name,
            'carOwnerLastName' => (string)$owner->last_name,
            'deliveryOnAirport' => (boolean)$trip->delivery_on_airport,
            'deliveryOnCarLocation' => (boolean)$trip->delivery_on_car_location,
            'deliveryOnRenterLocation' => (boolean)$trip->delivery_on_renter_location,
            'longitude' => (string)$trip->long_location,
            'latitude' => (string)$trip->lat_location,
            'pickupReturnLocation' => isset($airport) ? $airport->airport_name : null,
            'pickupReturnLocationArabic' => isset($airport) ? $airport->arabic_airport_name : null,
            'city' => (string)$trip->pickup_location,
	        'carId' => (int)$trip->car_id,
            'carManufacturer' => $trip->tripCar->car_manufacturer,
            'carModel' => $trip->tripCar->car_model,
            /*'carOriginalImagePath' => $trip->tripCar->original_image_path,
            'carSmallImagePath' => $trip->tripCar->small_image_path,*/
            'carOriginalImagePath' => $trip->car->carImage[0]->original_image_path,
            'carSmallImagePath' => $trip->car->carImage[0]->small_image_path,
            'tripConfirmedByRenter' => (string)$trip->renter_confirm_trip,
            'tripConfirmedByOwner' => (string)$trip->owner_confirm_trip,
            'tripUpdateConfirmedByRenter' => isset($trip->renter_confirm_trip_update) ? (boolean)$trip->renter_confirm_trip_update : null,
            'tripUpdateConfirmedByOwner' => isset($trip->owner_confirm_trip_update) ? (string)$trip->owner_confirm_trip_update : null,
	        'tripStatus' => (string)$trip->status,
	        'start_date' => (string)$trip->start_date,
	        'end_date' => (string)$trip->end_date,
	        'isTripModified' => (bool)$trip->is_trip_modified
        ];
    }

    /**
     * @param Trip $trip
     * @return \League\Fractal\Resource\Collection
     */
    public function includeTripBill(Trip $trip)
    {
        $tripBill = $trip->tripBill;
        return $this->collection($tripBill, new TripBillTransformer());
    }

    /**
     * @param Trip $trip
     * @return \League\Fractal\Resource\Item
     */
    public function includeCar(Trip $trip)
    {
        $car = $trip->car;
        return $this->item($car, new CarTransformer());
    }

    /**
     * @param Trip $trip
     * @return \League\Fractal\Resource\Item
     */
    public function includeChat(Trip $trip)
    {
        $chat = Chat::findOrFail($trip->chat_id);
        return $this->item($chat, new ChatTransformer());
    }

    /**
     * @param Trip $trip
     * @return \League\Fractal\Resource\Item|\League\Fractal\Resource\Primitive
     */
    public function includeReview(Trip $trip)
    {
        $review = $trip->review;
        $data = ['data' => $review];
        return $review === null ? $this->primitive($data) : $this->item($review, new ReviewTransformer);
    }
}
