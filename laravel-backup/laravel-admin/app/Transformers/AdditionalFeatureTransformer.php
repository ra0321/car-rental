<?php

namespace App\Transformers;

use App\AdditionalFeature;
use League\Fractal\TransformerAbstract;

/**
 * Class AdditionalFeatureTransformer
 * @package App\Transformers
 */
class AdditionalFeatureTransformer extends TransformerAbstract
{

	/**
	 * @param AdditionalFeature $additionalFeature
	 *
	 * @return array
	 */
	public function transform(AdditionalFeature $additionalFeature)
    {
        return [
        	'featureId' => (int)$additionalFeature->id,
        	'carId' => (int)$additionalFeature->car_id,
	        'featureName' => isset($additionalFeature->feature_name) ? (string)$additionalFeature->feature_name : null,
	        'isActive' => (boolean)$additionalFeature->is_active,
        ];
    }
}
