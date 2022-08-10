<?php

namespace App\Listeners\Car;

use Carbon\Carbon;
use App\CustomPrice;
use App\Events\Car\ListCar;

/**
 * Class CustomPriceEvent
 * @package App\Listeners\Car
 */
class CustomPriceEvent
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Handle the event.
     *
     * @param  ListCar  $event
     * @return void
     */
    public function handle(ListCar $event)
    {
        if(isset($event->request['car_odometer'])){
            $car_value = $event->request['car_value'];
            $old = $this->calculateYears($event->request['production_year']);
            $odometer = $this->odometerClass($event->request['car_odometer']);
            $index = $old * 70000;
            $amortization = $odometer - $index;
            $amortizationClass = $amortization / 70000;
            $insurance = ceil((($car_value * 5) / 100) + $car_value);
            $autoPrice = 0;
            $car_class = $event->car->model_class;

            switch ($car_class){
                case($car_class === 'economy cars'): // Economy cars
                    $autoPrice = $insurance / 600;
                    if($old > 0){
                        $autoPrice = $this->amortization($autoPrice, $old);
                    }
                    if($old < 4){
                        $autoPrice = $this->amortization($autoPrice, $amortizationClass);
                    }
                    break;
                case($car_class === 'small-size cars'): // Small - size cars
                    $autoPrice = $insurance / 500;
                    if($old > 0){
                        $autoPrice = $this->amortization($autoPrice, $old);
                    }
                    if($old < 4){
                        $autoPrice = $this->amortization($autoPrice, $amortizationClass);
                    }
                    break;
                case($car_class === 'mid-size cars'): // Mid - size cars
                    $autoPrice = $insurance / 450;
                    if($old > 0){
                        $autoPrice = $this->amortization($autoPrice, $old);
                    }
                    if($old < 4){
                        $autoPrice = $this->amortization($autoPrice, $amortizationClass);
                    }
                    break;
                case($car_class === 'full-size cars'): // Full - size cars
                    $autoPrice = $insurance / 400;
                    if($old > 0){
                        $autoPrice = $this->amortization($autoPrice, $old);
                    }
                    if($old < 4){
                        $autoPrice = $this->amortization($autoPrice, $amortizationClass);
                    }
                    break;
                case($car_class === 'luxury-class B cars'): // Luxury - class B cars
                    $autoPrice = $insurance / 350;
                    if($old > 0){
                        $autoPrice = $this->amortization($autoPrice, $old);
                    }
                    if($old < 4){
                        $autoPrice = $this->amortization($autoPrice, $amortizationClass);
                    }
                    break;
                case($car_class === 'suv and family cars'): // SUV and Family cars
                    $autoPrice = $insurance / 300;
                    if($old > 0){
                        $autoPrice = $this->amortization($autoPrice, $old);
                    }
                    if($old < 4){
                        $autoPrice = $this->amortization($autoPrice, $amortizationClass);
                    }
                    break;
                case($car_class === 'very luxury-class A cars'): // Very luxury - class A cars
                    $autoPrice = $insurance / 200;
                    if($old > 0){
                        $autoPrice = $this->amortization($autoPrice, $old);
                    }
                    if($old < 4){
                        $autoPrice = $this->amortization($autoPrice, $amortizationClass);
                    }
                    break;
            }

            $customPrice = new CustomPrice();
            $customPrice->car_id = $event->car->id;
            $customPrice->is_automatic_price = true;
            $customPrice->price = ceil($autoPrice);
            $customPrice->discount_week = 15;
            $customPrice->discount_month = 25;
            $customPrice->price_from_date = Carbon::now()->format('Y-m-d');
        }else{
            $customPrice = new CustomPrice();
            $customPrice->car_id = $event->car->id;
            $customPrice->price = 25;
            $customPrice->is_automatic_price = false;
            $customPrice->price_from_date = Carbon::now()->format('Y-m-d');
        }
        $customPrice->save();
    }

    /**
     * @param $production_year
     * @return string
     */
    private function calculateYears($production_year)
    {
        $currentYear = Carbon::now()->format('Y');
        $old = $currentYear - $production_year;
        return $old;
    }

    /**
     * @param $autoPrice
     * @param $iteration
     * @return float|int
     */
    private function amortization($autoPrice, $iteration)
    {
        for($i = 0; $i < $iteration; $i++){
            $amortization = ($autoPrice * 13) / 100;
            $autoPrice -= $amortization;
        }
        return $autoPrice;
    }

    /**
     * @param $car_odometer
     * @return int
     */
    private function odometerClass($car_odometer)
    {
        switch($car_odometer){
            case($car_odometer === '0-70k KM'):
                $odometer = 0;
                break;
            case($car_odometer === '70k-140k KM'):
                $odometer = 70000;
                break;
            case($car_odometer === '140k-210k KM'):
                $odometer = 140000;
                break;
            case($car_odometer === '210k-250k KM'):
                $odometer = 210000;
                break;
            default:
                $odometer = 0;
                break;
        }
        return $odometer;
    }
}
