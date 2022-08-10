<?php

namespace App\Transformers;

use App\Car;
use App\CarAirport;
use App\CarUnlisted;
use App\Helpers\Currency\CurrencyHelper;
use League\Fractal\Manager;
use League\Fractal\TransformerAbstract;

/**
 * Class CarTransformer
 * @package App\Transformers
 */
class CarTransformer extends TransformerAbstract
{

	/**
	 * @var array
	 */
	protected $defaultIncludes = [
		'carFeature', 'customPrice' , 'bookInstantly', 'carImage', 'carRegistration', 'carInsurance', 'carAirport',
        'carRestriction', 'carUnlisted' , 'carUnavailable',  'additionalFeature', 'carFaq'
	];

    /**
     * @var array
     */
    protected $availableIncludes = [
        'customPrice'
    ];

	/**
	 * @param Car $car
	 *
	 * @return array
	 */
	public function transform(Car $car)
    {
        $fractal = new Manager();

        if (isset($_POST['include'])) {
            $fractal->parseIncludes($_POST['include']);
        }

        $carStatus = CarUnlisted::where('car_id', $car->id)->orderBy('created_at', 'desc')->first();
        $carAirports = CarAirport::where('car_id', $car->id)->get();
        foreach($carAirports as $car_airport){
        	if($car_airport->work_on_airport == true){
        		$work_on_airport = true;
        		break;
	        }
        }
        return [
        	'carId' => (int)$car->id,
            'userId' => (int)$car->user_id,
	        'longitude' => (string)$car->long_location,
	        'latitude' => (string)$car->lat_location,
	        'cityCar' => (string)$car->car_city,
	        'carManufacturer' => (string)$car->car_manufacturer,
	        'carManufacturerArabic' => (string)$car->car_manufacturer_arabic,
	        'carModel' => (string)$car->car_model,
	        'yearOfProduction' => (string)$car->production_year,
            'carClass' => (string)$car->model_class,
	        'typeOfCar' => (string)$car->vehicle_type,
	        'carTrim' => isset($car->trim) ? (string)$car->trim : null,
	        'carStyle' => isset($car->style) ? (string)$car->style : null,
	        'carTransmission' => (string)$car->car_transmission,
	        'carIsBrended' => (boolean)$car->brended,
	        'valueOfCar' => CurrencyHelper::exchange((string)$car->car_value),
	        'registrationCardVerified' => (boolean)$car->is_registration_car_verified,
	        'insuranceVerified' => (boolean)$car->is_insurance_verified,
	        'carOdometer' => (string)$car->car_odometer,
	        'realOdometer' => (string)$car->real_odometer,
	        'shortestTrip' => (string)$car->short_trip,
	        'longestTrip' => (string)$car->long_trip,
            'weekendTrip' => (boolean)$car->weekend_trip,
            'longTermTrip' => (boolean)$car->long_term_trip,
            'deposit' => CurrencyHelper::exchange((int)$car->deposit),
            'countReviews' => isset($car->count_reviews) ? (float)$car->count_reviews : null,
            'countStars' => isset($car->count_stars) ? (float)$car->count_stars : null,
            'countTrips' => isset($car->count_trips) ? (int)$car->count_trips : null,
            'keyHandOff' => isset($car->key_hand_off) ? (string)$car->key_hand_off : null,
	        'parkingDetails' => isset($car->parking_details) ? $car->parking_details : null,
            'carStatus' => isset($carStatus) ? (string)$carStatus->car_status : 'listed',
	        'carInPhase' => (int)$car->phase,
	        'workOnAirport' => isset($work_on_airport) ? (boolean)$work_on_airport : false,
            'priceForFirstDay' => $car->priceForFirstDay ? CurrencyHelper::exchange((int)$car->priceForFirstDay) : null,
            'tripIdForSlider' => $car->tripIdForSlider ? (int)$car->tripIdForSlider : null,
            'paidAdvertising' => (boolean)$car->paid_advertising,
	        'isCarActive' => isset($car->car_is_active) ? (boolean)$car->car_is_active : false,
	        'isCarDeleted' => isset($car->is_deleted) ? (boolean)$car->is_deleted : false,
            'isFavorite' => isset($car->isFavorite) ? (boolean)$car->isFavorite : false,
            'deletedAt' => isset($car->deleted_at) ? (string)$car->deleted_at : null,
	        'advNotice' => (string)$car->notice,

	        'userNotice' => (string)$car->notice,
	        'carLocationNotice' => (string)$car->car_location_notice,
	        'airportNotice' => (string)$car->airport_notice,
	        'guestLocationNotice' => (string)$car->guest_location_notice,
        ];
    }

	/**
	 * @param Car $car
	 *
	 * @return \League\Fractal\Resource\Item
	 */
	public function includeCarFeature(Car $car)
	{
		$carFeature = $car->carFeature;
		return $this->item($carFeature, new CarFeatureTransformer());
    }

	/**
	 * @param Car $car
	 *
	 * @return \League\Fractal\Resource\Collection
	 */
	public function includeCustomPrice(Car $car)
	{
		$customPrice = $car->customPrice;
		return $this->collection($customPrice, new CustomPriceTransformer());
	}

    /**
     * @param Car $car
     *
     * @return \League\Fractal\Resource\Item
     */
    public function includeBookInstantly(Car $car)
    {
        $bookInstantly = $car->bookInstantly;
        return $this->item($bookInstantly, new BookInstantlyTransformer());
    }

	/**
	 * @param Car $car
	 *
	 * @return \League\Fractal\Resource\Collection
	 */
	public function includeCarImage(Car $car)
	{
		$carImage = $car->carImage;
        return $this->collection($carImage, new CarImageTransformer());
	}

	/**
	 * @param Car $car
	 *
	 * @return \League\Fractal\Resource\Collection
	 */
	public function includeAdditionalFeature(Car $car)
	{
		$carFeature = $car->additionalFeature;
        return $this->collection($carFeature, new AdditionalFeatureTransformer());
	}

	/**
	 * @param Car $car
	 *
	 * @return \League\Fractal\Resource\Collection
	 */
	public function includeCarFaq(Car $car)
	{
		$carFaq = $car->carFaq;
        return $this->collection($carFaq, new CarFaqTransformer());
	}

    /**
     * @param Car $car
     * @return \League\Fractal\Resource\Item|\League\Fractal\Resource\Primitive
     */
    public function includeCarRestriction(Car $car)
	{
        $restriction = $car->carRestriction;
        $data = ['data' => $restriction];
        return $restriction ? $this->item($restriction, new CarRestrictionTransformer()) : $this->primitive($data);
	}

    /**
     * @param Car $car
     * @return \League\Fractal\Resource\Item|\League\Fractal\Resource\Primitive
     */
    public function includeCarUnlisted(Car $car)
	{
        $unlisted = $car->carUnlisted()->where('car_id', $car->id)->orderBy('id', 'desc')->first();
        $data = ['data' => $unlisted];
        return $unlisted ? $this->item($unlisted, new CarUnlistedTransformer()) : $this->primitive($data);
	}

    /**
     * @param Car $car
     * @return \League\Fractal\Resource\Item|\League\Fractal\Resource\Primitive
     */
    public function includeCarRegistration(Car $car)
	{
        $registration = $car->carRegistration()->where('car_id', $car->id)->orderBy('id', 'desc')->first();
        $data = ['data' => $registration];
        return $registration ? $this->item($registration, new CarRegistrationTransformer()) : $this->primitive($data);
	}

    /**
     * @param Car $car
     * @return \League\Fractal\Resource\Item|\League\Fractal\Resource\Primitive
     */
    public function includeCarInsurance(Car $car)
	{
        $insurance = $car->carInsurance()->where('car_id', $car->id)->orderBy('id', 'desc')->first();
        $data = ['data' => $insurance];
        return $insurance ? $this->item($insurance, new CarInsuranceTransformer()) : $this->primitive($data);
	}

    /**
     * @param Car $car
     * @return \League\Fractal\Resource\Collection|null
     */
    public function includeCarAirport(Car $car)
    {
        $airports = $car->carAirport;
        return $this->collection($airports, new CarAirportTransformer());
	}

    /**
     * @param Car $car
     * @return \League\Fractal\Resource\Collection|null
     */
    public function includeCarUnavailable(Car $car)
    {
        $carAvailable = $car->carAvailable;
        return $this->collection($carAvailable, new CarAvailableTransformer());
    }
}
