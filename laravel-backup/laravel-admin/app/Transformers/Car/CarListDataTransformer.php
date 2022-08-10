<?php

namespace App\Transformers\Car;

use App\Car;
use League\Fractal\TransformerAbstract;

/**
 * Class CarListDataTransformer
 * @package App\Transformers\Car
 */
class CarListDataTransformer extends TransformerAbstract
{

    /**
     * @param Car $car
     * @return array
     */
    public function transform(Car $car)
    {
        $image = $car->carImage->first();
        return [
            'carId' => (int)$car->id,
            'carManufacturer' => (string)$car->car_manufacturer,
            'carManufacturerArabic' => (string)$car->car_manufacturer_arabic,
            'carModel' => (string)$car->car_model,
            'imageId' => isset($image) ? $image->id : null,
            'originalImagePath' => isset($image) ? (string)$image->original_image_path : null,
            'smallImagePath' => isset($image) ? (string)$image->small_image_path : null,
        ];
    }
}
