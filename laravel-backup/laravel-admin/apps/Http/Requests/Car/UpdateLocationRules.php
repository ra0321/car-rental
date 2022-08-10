<?php

namespace App\Http\Requests\Car;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class UpdateLocationRules extends FormRequest
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
        $now = Carbon::now();
        return [
            'long_location' => 'numeric',
            'lat_location' => 'numeric',
            'car_city' => 'string',
            'parking_details' => 'string|nullable',
            'key_hand_off' => 'string|nullable',
            'country' => 'string',
            'state' => 'string',
            'city' => 'string',
            'licence_plate' => 'string',
            'expiration_date' => 'date|after:' . $now->addDays(15),
            'date_of_issue' => 'date|before:' . $now,
            'licence_plate_image' => 'image|mimes:jpeg,jpg,png,JPG|dimensions:min_width=640,min_height=320',
        ];
    }
}
