<?php

namespace App\Transformers;

use App\RecentlyViewedCar;
use League\Fractal\TransformerAbstract;

/**
 * Class RecentlyViewedCarTransformer
 * @package App\Transformers
 */
class RecentlyViewedCarTransformer extends TransformerAbstract
{
    /**
     * @var array
     */
    protected $defaultIncludes = [
        'car'
    ];

	/**
	 * @param RecentlyViewedCar $recentlyViewedCar
	 * @return array
	 */
	public function transform(RecentlyViewedCar $recentlyViewedCar)
	{
		return [
			/*'userId' => (int)$recentlyViewedCar->user_id,
			'carId' => (int)$recentlyViewedCar->car_id,
			'lastTimeViewed' => (string)$recentlyViewedCar->updated_at,*/
		];
	}
    
    /**
     * @param RecentlyViewedCar $recentlyViewedCar
     * @return \League\Fractal\Resource\Item
     */
    public function includeCar(RecentlyViewedCar $recentlyViewedCar)
    {
        $car = $recentlyViewedCar->car;
        return $this->item($car, new CarTransformer());
    }
}
