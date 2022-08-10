<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\CarImage
 *
 * @property-read \App\Car $car
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CarImage newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CarImage newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CarImage query()
 * @mixin \Eloquent
 * @property int $id
 * @property int $car_id
 * @property string|null $original_image_path
 * @property string|null $small_image_path
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CarImage whereCarId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CarImage whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CarImage whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CarImage whereOriginalImagePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CarImage whereSmallImagePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CarImage whereUpdatedAt($value)
 */
class CarImage extends Model
{
    protected $table = 'car_images';

    public function car()
    {
        return $this->belongsTo(Car::class);
    }
}
