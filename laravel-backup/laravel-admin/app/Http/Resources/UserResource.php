<?php

namespace App\Http\Resources;

use App\DriverLicence;
use App\ID_Card;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class UserResource
 * @package App\Http\Resources
 */
class UserResource extends JsonResource
{

    /**
     * @param \Illuminate\Http\Request $request
     * @return array
     */
	function Number_SA($number, $country_code)
	{
		if ( !preg_match('/^\+\d{1,3}$/', $number)  ) {
			$number = $number;
		}
		else{
			$number = '+'.$country_code.$number;
		}
		//return the converted number:
		return $number;
	}

    public function toArray($request)
    {
        return [
            'id' => (string)$this->id,
            'active' => $this->user_active_status,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'phone_number' => $this->phone_number,
            'email_verified' => $this->email_verified,
            'phone_verified' => $this->phone_verified,
            'approved_to_drive' => $this->approved_to_drive,
            'id_verified' => $this->id_verified,
            'bank_name' => $this->bank_name,
            'iban' => $this->iban,
            'account_number' => $this->account_number,
            'holder_name' => $this->holder_name,
            'listed_cars' => $this->listed_cars,
            'reviewed' => $this->reviewed,
            'stars' => $this->stars,
            'trips_taken' => $this->trips_taken,
            'car_trips' => $this->car_trips,
            'number_of_penalties' => $this->count_penalty,
            'penalty_amount' => $this->penalty_amount,
            'accepted_trips_in_row' => $this->accepted_trips_in_row,
            'cancelations_in_row' => $this->cancelation_in_row,
            'joined' => $this->created_at->format('d m Y'),
            'profile' => ProfileResource::make($this->whenLoaded('profile')),
            'cars' => CarResource::collection($this->whenLoaded('car')),
            'cars_count' => $this->car_count,
			'earnings' => round($this->earnings(), 2),
			'trips' => $this->whenLoaded('owner'),
			'bills' => $this->whenLoaded('bills'),
            'id_card' => $this->whenLoaded('idCard'),
            'driver_licence' => $this->whenLoaded('driverLicenceCard'),
            'note' => $this->note->first(),
        ];
    }


    public function withResponse($request, $response)
    {
        $response->header('X-Value', 'True');
    }
}
