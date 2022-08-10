<?php

namespace App\Transformers;

use App\AllCar;
use League\Fractal\TransformerAbstract;

/**
 * Class SelectCarTransformer
 * @package App\Transformers
 */
class SelectCarTransformer extends TransformerAbstract
{

    /**
     * @param AllCar $selectCar
     * @return array
     */
    public function transform(AllCar $selectCar)
    {
        return [
            'carId' => (int)$selectCar->id,
            'carManufacturer' => (string)$selectCar->model_make_id,
            'carManufacturerArabic' => (string)$selectCar->manufacturer_arabic,
            'carModel' => (string)$selectCar->model_name,
            'carTrim' => isset($selectCar->model_trim) ? (string)$selectCar->model_trim : null,
            'carProductionYear' => (string)$selectCar->model_year,
            'carClass' => (string)$selectCar->model_class,
            'carStyle' => isset($selectCar->model_body) ? (string)$selectCar->model_body : null,
            'carFuel' => isset($selectCar->model_engine_fuel) ? (string)$selectCar->model_engine_fuel : null,
            'carTransmission' => (string)$selectCar->model_transmission_type,
            'carTransmissionArabic' => (string)$selectCar->model_transmission_type_arabic,
            'carSeats' => isset($selectCar->model_seats) ? (string)$selectCar->model_seats : null,
            'carDoors' => isset($selectCar->model_doors) ? (string)$selectCar->model_doors : null,
            'highwayLKM' => isset($selectCar->model_lkm_hwy) ? (string)$selectCar->model_lkm_hwy : null,
            'cityLKM' => isset($selectCar->model_lkm_city) ? (string)$selectCar->model_lkm_city : null,
        ];
    }
}
