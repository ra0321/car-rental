<?php

namespace App\Transformers;

use App\CarFaq;
use League\Fractal\TransformerAbstract;

/**
 * Class CarFaqTransformer
 * @package App\Transformers
 */
class CarFaqTransformer extends TransformerAbstract
{

	/**
	 * @param CarFaq $carFaq
	 *
	 * @return array
	 */
	public function transform(CarFaq $carFaq)
    {
        return [
        	'carFaqId' => (int)$carFaq->id,
	        'carId' => (int)$carFaq->car_id,
            'question' => isset($carFaq->question) ? (string)$carFaq->question : null,
            'answer' => isset($carFaq->answer) ? (string)$carFaq->answer : null,
	        'isActive' => (boolean)$carFaq->is_active,
        ];
    }
}
