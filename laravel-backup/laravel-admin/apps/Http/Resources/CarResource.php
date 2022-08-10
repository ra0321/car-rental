<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CarResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
		// dd($this);
        return [
            'id' => (string)$this->id,
            'long_location' => $this->long_location,
            'lat_location' => $this->lat_location,
            'car_city' => $this->car_city,
            'car_manufacturer' => $this->car_manufacturer,
            'car_model' => $this->car_model,
            'production_year' => $this->production_year,
            'model_class' => $this->model_class,
            'trim' => $this->trim,
            'style' => $this->style,
            'transmission' => $this->car_transmission,
            'type' => $this->vehicle_type,
            'car_odometer' => $this->car_odometer,
            'real_odometer' => $this->real_odometer,
            'brended' => $this->brended,
            'value' => $this->car_value,
            'deposit' => $this->deposit,
            'stars' => $this->count_stars,
            'reviews' => $this->count_reviews,
            'key_handoff' => $this->key_hand_off,
            'parking_details' => $this->parking_details,
            'notice' => $this->notice,
            'car_location_notice' => $this->car_location_notice,
            'airport_notice' => $this->airport_notice,
            'guest_location_notice' => $this->guest_location_notice,
            'shortest_trip' => $this->short_trip,
            'longest_trip' => $this->long_trip,
            'weekend_trip' => $this->weekend_trip,
            'long_term_trip' => $this->long_term_trip,
            'verified_registration' => $this->is_registration_car_verified,
            'verified_insurance' => $this->is_insurance_verified,
            'active' => $this->car_is_active,
            'paid_advertising' => $this->paid_advertising,
            'created_at' => $this->created_at->format('d m Y'),
            'updated_at' => $this->updated_at->format('d m Y'),
            'images' => $this->whenLoaded('carImage'),
            'owner' => $this->whenLoaded('user'),
			'trips' => $this->whenLoaded('trip')
        ];
    }
}
