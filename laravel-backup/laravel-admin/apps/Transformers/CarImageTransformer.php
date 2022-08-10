<?php

namespace App\Transformers;

use App\CarImage;
use League\Fractal\TransformerAbstract;

/**
 * Class CarImageTransformer
 * @package App\Transformers
 */
class CarImageTransformer extends TransformerAbstract
{

	/**
	 * @param CarImage $image
	 *
	 * @return array
	 */
	public function transform(CarImage $image)
    {
        return [
        	'imageId' => $image->id,
            'originalImagePath' => isset($image->original_image_path) ? (string)$image->original_image_path : null,
            'bigImagePath' => isset($image->big_image_path) ? (string)$image->big_image_path : null,
            'smallImagePath' => isset($image->small_image_path) ? (string)$image->small_image_path : null,
            'iconImagePath' => isset($image->icon_image_path) ? (string)$image->icon_image_path : null,
        ];
    }
}
