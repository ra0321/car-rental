<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\ID_Card
 *
 * @property int $id
 * @property int $user_id
 * @property string|null $first_name
 * @property string|null $last_name
 * @property string|null $middle_name
 * @property string|null $dob
 * @property string|null $id_number
 * @property string|null $id_country
 * @property string|null $id_state
 * @property string|null $id_city
 * @property string|null $date_of_issue
 * @property string|null $expiration_date
 * @property string|null $issued_by
 * @property int|null $expired
 * @property string|null $image_path
 * @property string|null $image_path_small
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ID_Card newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ID_Card newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ID_Card query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ID_Card whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ID_Card whereDateOfIssue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ID_Card whereDob($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ID_Card whereExpirationDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ID_Card whereExpired($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ID_Card whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ID_Card whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ID_Card whereIdCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ID_Card whereIdCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ID_Card whereIdNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ID_Card whereIdState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ID_Card whereImagePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ID_Card whereImagePathSmall($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ID_Card whereIssuedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ID_Card whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ID_Card whereMiddleName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ID_Card whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ID_Card whereUserId($value)
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ID_Card lastIdCard($profile)
 */
class ID_Card extends Model
{
    protected $fillable = [

    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeLastIdCard($query, $profile)
    {
        return $query
            ->where('user_id', $profile->user_id)
            ->orderBy('id', 'desc');
    }
}
