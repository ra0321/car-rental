<?php

namespace App\Http\Requests\Car;

use App\Car;
use Carbon\Carbon;
use App\Rules\RealBool;
use Illuminate\Foundation\Http\FormRequest;

class CarFeatureRules extends FormRequest
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
	    $carModel = $this->route('car');
	    $car = Car::where('id', $carModel->id)->firstOrFail();
	    $now = Carbon::now();
	    if($car['is_registration_car_verified']){
		    return [
			    'car_description' => 'string|max:10000|nullable',
                'hybrid' => [new RealBool(HYBRID)],
                'bike_rack' => [new RealBool(BIKE_RACK)],
                'all_drive' => [new RealBool(ALL_DRIVE)],
                'child_seat' => [new RealBool(CHILD_SEAT)],
                'gps' => [new RealBool(GPS)],
                'ski_rack' => [new RealBool(SKI_RACK)],
                'bluetooth' => [new RealBool(BLUETOOTH)],
                'usb' => [new RealBool(USB)],
                'ventilated_seat' => [new RealBool(VENTILATED_SEAT)],
                'audio_input' => [new RealBool(AUDIO_INPUT)],
                'convertible' => [new RealBool(CONVERTIBLE)],
                'toll_pass' => [new RealBool(TOLL_PASS)],
                'sunroof' => [new RealBool(SUNROOF)],
                'pet_friendly' => [new RealBool(PET_FRIENDLY)],
                'heated_seat' => [new RealBool(HEATED_SEAT)],
		    ];
	    }
        return [
        	'country' => 'required|string',
        	'state' => 'required|string',
	        'city' => 'required|string',
	        'licence_plate' => 'required',
            'expiration_date' => 'required|date|after:' . $now->addDays(15),
            'date_of_issue' => 'required|date|before:' . $now,
	        'licence_plate_image' => 'required|image|mimes:jpeg,png,jpg,JPG|dimensions:min_width=640,min_height=320',
	        'car_description' => 'string|max:10000|nullable',
	        'hybrid' => [new RealBool(HYBRID)],
	        'bike_rack' => [new RealBool(BIKE_RACK)],
	        'all_drive' => [new RealBool(ALL_DRIVE)],
	        'child_seat' => [new RealBool(CHILD_SEAT)],
	        'gps' => [new RealBool(GPS)],
	        'ski_rack' => [new RealBool(SKI_RACK)],
	        'bluetooth' => [new RealBool(BLUETOOTH)],
	        'usb' => [new RealBool(USB)],
	        'ventilated_seat' => [new RealBool(VENTILATED_SEAT)],
	        'audio_input' => [new RealBool(AUDIO_INPUT)],
	        'convertible' => [new RealBool(CONVERTIBLE)],
	        'toll_pass' => [new RealBool(TOLL_PASS)],
	        'sunroof' => [new RealBool(SUNROOF)],
	        'pet_friendly' => [new RealBool(PET_FRIENDLY)],
	        'heated_seat' => [new RealBool(HEATED_SEAT)],
        ];
    }
}
