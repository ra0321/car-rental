<?php

namespace App\Transformers;

use App\CarAirport;
use App\Helpers\Currency\CurrencyHelper;
use League\Fractal\TransformerAbstract;

/**
 * Class CarAirportTransformer
 * @package App\Transformers
 */
class CarAirportTransformer extends TransformerAbstract
{

    /**
     * @param CarAirport $carAirport
     * @return array
     */
    public function transform(CarAirport $carAirport)
    {
        return [
            'airportId' => (int)$carAirport->id,
            'airportName' => (string)$carAirport->airport_name,
            'airportCity' => (string)$carAirport->airport_city,
            'airportState' => (string)$carAirport->airport_state,
            'airportLatitude' => (string)$carAirport->latitude,
            'airportLongitude' => (string)$carAirport->longitude,
            'airportRegion' => (string)$carAirport->region,
            'deliveryFee' => isset($carAirport->delivery_fee) ? CurrencyHelper::exchange((int)$carAirport->delivery_fee) : null,
            'workOnAirport' => (boolean)$carAirport->work_on_airport,
            'arabicAirportName' => (string)$carAirport->arabic_airport_name,
            'arabicAirportCity' => (string)$carAirport->arabic_airport_city,
            'arabicAirportState' => (string)$carAirport->arabic_airport_state,
            'updatedAt' => (string)$carAirport->updated_at,
        ];
    }
}
