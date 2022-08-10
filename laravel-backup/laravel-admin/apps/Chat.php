<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Chat
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\ChatMessage[] $messages
 * @property-read \App\User $owner
 * @property-read \App\User $renter
 * @property-read \App\Trip $trip
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Chat newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Chat newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Chat query()
 * @mixin \Eloquent
 * @property int $id
 * @property int|null $trip_id
 * @property int $renter_id
 * @property int $owner_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read int|null $messages_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Chat whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Chat whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Chat whereOwnerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Chat whereRenterId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Chat whereTripId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Chat whereUpdatedAt($value)
 */
class Chat extends Model
{

    protected $with = ['messages'];

    public function trip()
    {
        return $this->belongsTo(Trip::class);
    }

    public function messages()
    {
        return $this->hasMany(ChatMessage::class);
    }

    public function renter()
    {
        return $this->hasOne(User::class, 'id', 'renter_id');
    }

    public function owner()
    {
        return $this->hasOne(User::class, 'id', 'owner_id');
    }
}
