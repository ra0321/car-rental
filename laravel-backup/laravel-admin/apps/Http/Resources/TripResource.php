<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TripResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
		// dd($this->renter);
        return [
            'id' => (string)$this->id,
            'owner_id' => $this->owner_id,
            'renter_id' => $this->renter_id,
            'delivery_on_airport' => $this->delivery_on_airport,
            'delivery_on_renter_location' => $this->delivery_on_renter_location,
            'delivery_on_car_location' => $this->delivery_on_car_location,
            'long_location' => $this->long_location,
            'lat_location' => $this->lat_location,
            'pickup_location' => $this->pickup_location,
            'notice_time' => $this->notice_time,
            'booked_instantly' => $this->booked_instantly,
            'renter_confirm_trip' => $this->renter_confirm_trip,
            'owner_confirm_trip' => $this->owner_confirm_trip,
            'status' => $this->status,
            'renter_confirm_trip_update' => $this->renter_confirm_trip_update,
            'owner_confirm_trip_update' => $this->owner_confirm_trip_update,
            'trip_modified' => $this->trip_modified,
            'i_agree' => $this->i_agree,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'created_at' => $this->created_at->format('d m Y'),
            'updated_at' => $this->updated_at->format('d m Y'),
            'car' => $this->whenLoaded('car'),
            'trip_bills' => $this->whenLoaded('tripBills'),
            'trip_images' => $this->whenLoaded('tripImages'),
            'renter' => $this->renter,
			'owner' => $this->owner,
        ];
    }
}
