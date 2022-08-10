<?php

namespace App\Http\Requests\Car;

use App\Rules\RealBool;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class ManageAirportRules
 * @package App\Http\Requests\Car
 */
class ManageAirportRules extends FormRequest
{
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
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'airports' => 'array',
            'airports.*.id' => 'integer',
            'airports.*.delivery_fee' => 'nullable|numeric|min:0|max:100',
            'airports.*.work_on_airport' => [new RealBool(WORK_ON_AIRPORT)],

            'guest_location' => 'array',
            'guest_location.work_on_guest_location' => [new RealBool(WORK_ON_GUEST_LOCATION)],
            'guest_location.delivery_fee_guest_location' => 'nullable|integer|min:0|max:100|required_if:guest_location.work_on_guest_location,true',
            'guest_location.max_distance' => 'nullable|integer|min:0|max:50|required_if:guest_location.work_on_guest_location,true',
            'guest_location.min_trip_for_free_delivery' => 'integer|numeric|min:0|max:30',
            'guest_location.guest_location_delivery_details' => 'string|nullable',
        ];
    }
}
