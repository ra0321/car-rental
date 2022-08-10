<?php

namespace App\Transformers;

use App\CarFeature;
use League\Fractal\TransformerAbstract;

/**
 * Class CarFeatureTransformer
 * @package App\Transformers
 */
class CarFeatureTransformer extends TransformerAbstract
{

	/**
	 * @param CarFeature $carFeature
	 *
	 * @return array
	 */
	public function transform(CarFeature $carFeature)
    {
        return [
	        'carColor' => isset($carFeature->color) ? (string)$carFeature->color : null,
	        'carSeats' => isset($carFeature->model_seats) ? (integer)$carFeature->model_seats : null,
	        'carDoors' => isset($carFeature->model_doors) ? (integer)$carFeature->model_doors : null,
	        'fuelType' => isset($carFeature->model_engine_fuel) ? (string)$carFeature->model_engine_fuel : null,
	        'gasGrade' => isset($carFeature->gas_grade) ? (string)$carFeature->gas_grade : null,
	        'cityLKM' => isset($carFeature->model_lkm_city) ? (integer)$carFeature->model_lkm_city : null,
	        'highwayLKM' => isset($carFeature->model_lkm_hwy) ? (integer)$carFeature->model_lkm_hwy : null,
	        'hybrid' => isset($carFeature->hybrid) ? (boolean)$carFeature->hybrid : null,
	        'bikeRack' => isset($carFeature->bike_rack) ? (boolean)$carFeature->bike_rack : null,
	        'all4Drive' => isset($carFeature->all_drive) ? (boolean)$carFeature->all_drive : null,
	        'childSeat' => isset($carFeature->child_seat) ? (boolean)$carFeature->child_seat : null,
	        'GPS' => isset($carFeature->gps) ? (boolean)$carFeature->gps : null,
	        'skiRack' => isset($carFeature->ski_rack) ? (boolean)$carFeature->ski_rack : null,
	        'bluetooth' => isset($carFeature->bluetooth) ? (boolean)$carFeature->bluetooth : null,
	        'usb' => isset($carFeature->usb) ? (boolean)$carFeature->usb : null,
	        'ventilatedSeat' => isset($carFeature->ventilated_seat) ? (boolean)$carFeature->ventilated_seat : null,
	        'audioInput' => isset($carFeature->audio_input) ? (boolean)$carFeature->audio_input : null,
	        'convertible' => isset($carFeature->convertible) ? (boolean)$carFeature->convertible : null,
	        'tollPass' => isset($carFeature->toll_pass) ? (boolean)$carFeature->toll_pass : null,
	        'sunroof' => isset($carFeature->sunroof) ? (boolean)$carFeature->sunroof : null,
	        'petFriendly' => isset($carFeature->pet_friendly) ? (boolean)$carFeature->pet_friendly : null,
	        'heatedSeat' => isset($carFeature->heated_seat) ? (boolean)$carFeature->heated_seat : null,
	        'carTitle' => isset($carFeature->car_title) ? (string)$carFeature->car_title : null,
	        'carDescription' => isset($carFeature->car_description) ? (string)$carFeature->car_description : null,
	        'carGuidelines' => isset($carFeature->car_guidelines) ? (string)$carFeature->car_guidelines : null,
        ];
    }
}
