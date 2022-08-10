<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RentalCalculatorResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
        	'id' => (string)$this->id,
	        'email' => $this->email,
	        'phone' => $this->phone,
	        'carManufacturer' => $this->car_manufacturer,
	        'carManufacturerArabic' => $this->car_manufacturer_arabic,
	        'carModel' => $this->car_model,
	        'productionYear' => $this->production_year,
	        'class' => $this->model_class,
	        'trim' => $this->trim,
	        'style' => $this->style,
	        'carTransmission' => $this->car_transmission,
	        'carTransmissionArabic' => $this->car_transmission_arabic,
	        'carValue' => $this->car_value,
	        'vehicleType' => $this->vehicle_type,
	        'vehicleTypeArabic' => $this->vehicle_type_arabic,
	        'carOdometer' => $this->car_odometer,
	        'realOdometer' => $this->real_odometer,
	        'dailyPrice' => $this->daily_price,
	        'yearlyPrice' => $this->yearly_price,
	        'created' => $this->created_at->format('d-M-Y')
        ];
    }
}
