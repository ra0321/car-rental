<?php

namespace App;

use App\Transformers\CarRegistrationTransformer;
use Illuminate\Database\Eloquent\Model;

/**
 * App\CarFeatures
 */
class CarFeatures extends Model
{
	/**
	 * @var string
	 */
	public $transformer = CarRegistrationTransformer::class;

	/**
	 * @var array
	 */
	protected $fillable = [
	    'car_id', 'color', 'model_seats', 'model_doors', 'model_engine_fuel', 'gas_grade', 'model_lkm_city', 'model_lkm_hwy', 'hybrid', 'bike_rack', 'all_drive', 'child_seat', 'gps', 'ski_rack', 'bluetooth', 'usb', 'ventilated_seat', 'audio_input', 'convertible', 'toll_pass', 'sunroof', 'pet_friendly', 'heated_seat', 'car_title', 'car_description', 'car_guidelines'
    ];

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function car()
	{
		return $this->belongsTo(Car::class);
	}
}
