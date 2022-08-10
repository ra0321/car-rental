<?php

namespace App;

use App\Transformers\SelectCarTransformer;
use Illuminate\Database\Eloquent\Model;

/**
 * App\AllCar
 *
 * @property int $id
 * @property string|null $model_make_id
 * @property string|null $manufacturer_arabic
 * @property string|null $model_name
 * @property string|null $model_trim
 * @property string|null $model_year
 * @property string|null $model_class
 * @property string|null $model_body
 * @property string|null $model_engine_fuel
 * @property string|null $model_transmission_type
 * @property string|null $model_transmission_type_arabic
 * @property string|null $model_seats
 * @property string|null $model_doors
 * @property string|null $model_lkm_hwy
 * @property string|null $model_lkm_city
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AllCar whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AllCar whereManufacturerArabic($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AllCar whereModelBody($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AllCar whereModelClass($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AllCar whereModelDoors($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AllCar whereModelEngineFuel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AllCar whereModelLkmCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AllCar whereModelLkmHwy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AllCar whereModelMakeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AllCar whereModelName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AllCar whereModelSeats($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AllCar whereModelTransmissionType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AllCar whereModelTransmissionTypeArabic($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AllCar whereModelTrim($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AllCar whereModelYear($value)
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AllCar newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AllCar newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AllCar query()
 */
class AllCar extends Model
{
    public $transformer = SelectCarTransformer::class;
    /**
     * @var string
     */
    protected $table = 'esar_cars';
}
