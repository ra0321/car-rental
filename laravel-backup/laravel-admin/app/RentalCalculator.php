<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\RentalCalculator
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\RentalCalculator newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\RentalCalculator newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\RentalCalculator query()
 * @mixin \Eloquent
 * @property int $id
 * @property string $email
 * @property string $phone
 * @property string $car_manufacturer
 * @property string $car_manufacturer_arabic
 * @property string $car_model
 * @property string $production_year
 * @property string $model_class
 * @property string|null $trim
 * @property string|null $style
 * @property string $car_transmission
 * @property string|null $car_transmission_arabic
 * @property string $car_value
 * @property string $vehicle_type
 * @property string $vehicle_type_arabic
 * @property string|null $car_odometer
 * @property string|null $real_odometer
 * @property string $daily_price
 * @property string $yearly_price
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\RentalCalculator whereCarManufacturer($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\RentalCalculator whereCarManufacturerArabic($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\RentalCalculator whereCarModel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\RentalCalculator whereCarOdometer($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\RentalCalculator whereCarTransmission($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\RentalCalculator whereCarTransmissionArabic($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\RentalCalculator whereCarValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\RentalCalculator whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\RentalCalculator whereDailyPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\RentalCalculator whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\RentalCalculator whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\RentalCalculator whereModelClass($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\RentalCalculator wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\RentalCalculator whereProductionYear($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\RentalCalculator whereRealOdometer($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\RentalCalculator whereStyle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\RentalCalculator whereTrim($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\RentalCalculator whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\RentalCalculator whereVehicleType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\RentalCalculator whereVehicleTypeArabic($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\RentalCalculator whereYearlyPrice($value)
 */
class RentalCalculator extends Model
{
    //

    public function scopeSearchId($query, $s)
    {
        if ($s) $query->where('id', 'like', '%'.$s.'%');
    }

    public function scopeSearchEmail($query, $s)
    {
        if ($s) $query->orWhere('email', 'like', '%'.$s.'%');
    }
    public function scopeSearchPhone($query, $s)
    {
        if ($s) $query->orWhere('phone', 'like', '%'.$s.'%');
    }

    public function scopeSearchCarManufacturer($query, $s)
    {
        if ($s) $query->orWhere('car_manufacturer', 'like', '%'.$s.'%');
    }
    public function scopeSearchCarManufacturerArabic($query, $s)
    {
        if ($s) $query->orWhere('car_manufacturer_arabic', 'like', '%'.$s.'%');
    }
    

    public function scopeSearchCarModel($query, $s)
    {
        if ($s) $query->orWhere('car_model', 'like', '%'.$s.'%');
    }
    public function scopeSearchCarProdYear($query, $s)
    {
        if ($s) $query->orWhere('production_year', 'like', '%'.$s.'%');
    }
    public function scopeSearchCarModelClass($query, $s)
    {
        if ($s) $query->orWhere('model_class', 'like', '%'.$s.'%');
    }
    public function scopeSearchCarTransmission($query, $s)
    {
        if ($s) $query->orWhere('car_transmission', 'like', '%'.$s.'%');
    }
    public function scopeSearchCarTransmissionArabic($query, $s)
    {
        if ($s) $query->orWhere('car_transmission_arabic', 'like', '%'.$s.'%');
    }

    public function scopeSearchCarValue($query, $s)
    {
        if ($s) $query->orWhere('car_transmission_arabic', 'like', '%'.$s.'%');
    }

    public function scopeSearchVehicleType($query, $s)
    {
        if ($s) $query->orWhere('vehicle_type', 'like', '%'.$s.'%');
    }
    public function scopeSearchVehicleTypeArabic($query, $s)
    {
        if ($s) $query->orWhere('vehicle_type_arabic', 'like', '%'.$s.'%');
    }

    public function scopeSearchCarOdometer($query, $s)
    {
        if ($s) $query->orWhere('car_odometer', 'like', '%'.$s.'%');
    }

    public function scopeSearchCarRealOdometer($query, $s)
    {
        if ($s) $query->orWhere('real_odometer', 'like', '%'.$s.'%');
    }

    public function scopeSearchCarDailyPrice($query, $s)
    {
        if ($s) $query->orWhere('daily_price', 'like', '%'.$s.'%');
    }

    public function scopeSearchCarTearlyPrice($query, $s)
    {
        if ($s) $query->orWhere('yearly_price', 'like', '%'.$s.'%');
    }


    public function scopeSearchDateRange($query, $s)
    {
        if (!empty($s)) $query->whereBetween('created_at', $s);
    }
}
