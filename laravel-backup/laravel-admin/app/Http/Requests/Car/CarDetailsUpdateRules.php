<?php

namespace App\Http\Requests\Car;

use App\Rules\RealBool;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class CarDetailsUpdateRules extends FormRequest
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
	        'car_title' => 'string|max:2500|nullable',
	        'car_description' => 'string|max:10000|nullable',
	        'car_guidelines' => 'string|max:10000|nullable',
	        'color' => ['nullable', Rule::in(['red', 'yellow', 'green', 'blue', 'gold', 'white', 'black', 'gray', 'silver', 'other'])],
	        'model_seats' => 'numeric|min:2|max:10|nullable',
	        'model_doors' => 'numeric|min:2|max:5|nullable',
	        'model_engine_fuel' => ['nullable', Rule::in(['Gasoline', 'Gasoline - Premium', 'Diesel', 'Gasoline / Electric Hybrid', 'Diesel / Electric Hybrid',
                'Flex-Fuel', 'Natural Gas (CNG)', 'Electric', 'LPG', 'Premium', 'Premium Unleaded', 'Regular Unleaded', 'Flex-Fuel (Premium Unleaded/E85)',
                'Flex-Fuel (Unleaded/E85)', 'Flex-Fuel (Unleaded/Natural Gas)', 'Natural Gas'])],
	        'gas_grade' => ['nullable', Rule::in(['premium', 'regular'])],
	        'model_lkm_city' => 'numeric|min:5|max:50|nullable',
	        'model_lkm_hwy' => 'numeric|min:5|max:50|nullable',
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
            'additional_feature' => 'array|max:5',
            'additional_feature.*.id' => 'numeric',
            'additional_feature.*.feature_name' => 'string|max:100|nullable',
            'faq' => 'array|max:5',
            'faq.*.id' => 'numeric',
            'faq.*.question' => 'required_with:faq.*.answer|string|max:180|nullable',
            'faq.*.answer' => 'required_with:faq.*.question|string|max:1000|nullable'
        ];
    }
}
