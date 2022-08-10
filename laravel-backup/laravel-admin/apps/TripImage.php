<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\TripImage
 *
 * @property-read \App\Trip $trip
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TripImage newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TripImage newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TripImage query()
 * @mixin \Eloquent
 * @property int $id
 * @property int $trip_id
 * @property int $user_id
 * @property string $image_path
 * @property int|null $before_trip
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TripImage whereBeforeTrip($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TripImage whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TripImage whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TripImage whereImagePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TripImage whereTripId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TripImage whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TripImage whereUserId($value)
 */
class TripImage extends Model
{
    protected $table = 'trip_images';

    public function trip()
    {
        return $this->belongsTo(Trip::class);
    }
}
