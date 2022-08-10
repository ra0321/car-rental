<?php

namespace App\Transformers;

use App\FavoriteCar;
use League\Fractal\TransformerAbstract;

/**
 * Class FavoriteCarTransformer
 * @package App\Transformers
 */
class FavoriteCarTransformer extends TransformerAbstract
{

    /**
     * @var array
     */
    protected $defaultIncludes = [
        'car'
    ];

	/**
	 * @param FavoriteCar $favoriteCar
	 *
	 * @return array
	 */
	public function transform(FavoriteCar $favoriteCar)
    {
        return [
	        'carId' => (int)$favoriteCar->car_id,
	        'createdAt' => isset($favoriteCar->created_at) ? (string)$favoriteCar->created_at : null,
        ];
    }

    /**
     * @param FavoriteCar $favoriteCar
     * @return \League\Fractal\Resource\Item
     */
    public function includeCar(FavoriteCar $favoriteCar)
    {
        $car = $favoriteCar->car;
        return $this->item($car, new CarTransformer());
    }
}
