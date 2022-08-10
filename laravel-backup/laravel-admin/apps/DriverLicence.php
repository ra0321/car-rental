<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\DriverLicence
 *
 * @property int $id
 * @property int $user_id
 * @property string|null $dl_number
 * @property string|null $country
 * @property string|null $state
 * @property string|null $city
 * @property string|null $issued_by
 * @property string|null $date_of_issue
 * @property string|null $expiration_date
 * @property int|null $expired
 * @property string|null $image_path
 * @property string|null $image_path_small
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DriverLicence newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DriverLicence newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DriverLicence query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DriverLicence whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DriverLicence whereCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DriverLicence whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DriverLicence whereDateOfIssue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DriverLicence whereDlNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DriverLicence whereExpirationDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DriverLicence whereExpired($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DriverLicence whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DriverLicence whereImagePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DriverLicence whereImagePathSmall($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DriverLicence whereIssuedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DriverLicence whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DriverLicence whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DriverLicence whereUserId($value)
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DriverLicence lastDLCard($profile)
 */
class DriverLicence extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeLastDLCard($query, $profile)
    {
        return $query
            ->where('user_id', $profile->user_id)
            ->orderBy('id', 'desc');
    }
}
