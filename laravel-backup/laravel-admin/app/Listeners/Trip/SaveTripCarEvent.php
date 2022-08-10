<?php

namespace App\Listeners\Trip;

use App\CarFeature;
use App\CarImage;
use App\TripCar;
use PDOException;

/**
 * Class SaveTripCarEvent
 * @package App\Listeners\Trip
 */
class SaveTripCarEvent
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * @param $event
     */
    public function handle($event)
    {
	    $carFeatures = CarFeature::where('car_id', $event->data['car']->id)->first()->toArray();
        $carImages = CarImage::where('car_id', $event->data['car']->id)->first()->toArray();
        $tripCar = new TripCar();

        $tripCar['trip_id'] = $event->data['trip']->id;
        $tripCar['car_id'] = $event->data['car']->id;
        $tripCar['car_manufacturer'] = $event->data['car']->car_manufacturer;
        $tripCar['car_manufacturer_arabic'] = $event->data['car']->car_manufacturer_arabic;
        $tripCar['car_model'] = $event->data['car']->car_model;
        $tripCar['color'] = $carFeatures['color'];
        $tripCar['model_seats'] = $carFeatures['model_seats'];
        $tripCar['model_doors'] = $carFeatures['model_doors'];
        $tripCar['model_engine_fuel'] = $carFeatures['model_engine_fuel'];
        $tripCar['gas_grade'] = $carFeatures['gas_grade'];
        $tripCar['model_lkm_city'] = $carFeatures['model_lkm_city'];
        $tripCar['model_lkm_hwy'] = $carFeatures['model_lkm_hwy'];
        $tripCar['hybrid'] = $carFeatures['hybrid'];
        $tripCar['bike_rack'] = $carFeatures['bike_rack'];
        $tripCar['all_drive'] = $carFeatures['all_drive'];
        $tripCar['child_seat'] = $carFeatures['child_seat'];
        $tripCar['gps'] = $carFeatures['gps'];
        $tripCar['ski_rack'] = $carFeatures['ski_rack'];
        $tripCar['bluetooth'] = $carFeatures['bluetooth'];
        $tripCar['usb'] = $carFeatures['usb'];
        $tripCar['ventilated_seat'] = $carFeatures['ventilated_seat'];
        $tripCar['audio_input'] = $carFeatures['audio_input'];
        $tripCar['convertible'] = $carFeatures['convertible'];
        $tripCar['toll_pass'] = $carFeatures['toll_pass'];
        $tripCar['sunroof'] = $carFeatures['sunroof'];
        $tripCar['car_title'] = $carFeatures['car_title'];
        $tripCar['car_description'] = $carFeatures['car_description'];
        $tripCar['car_guidelines'] = $carFeatures['car_guidelines'];
        $tripCar['original_image_path'] = $carImages['original_image_path'];
        $tripCar['small_image_path'] = $carImages['small_image_path'];

	    try{
		    $tripCar->save();
	    }catch(PDOException $exception){
		    $error_message = $exception->getMessage();
		    $error_code = (int)$exception->getCode();
		    throw new PDOException($error_message, $error_code);
	    }

    }
}
