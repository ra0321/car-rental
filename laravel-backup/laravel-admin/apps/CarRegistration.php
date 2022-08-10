<?php

namespace App;

use App\Transformers\CarRegistrationTransformer;
use Illuminate\Database\Eloquent\Model;

/**
 * App\CarRegistration
 *
 * @property int $id
 * @property int $car_id
 * @property string $country
 * @property string $state
 * @property string $city
 * @property string $licence_plate
 * @property string|null $expiration_date
 * @property string|null $date_of_issue
 * @property string $small_car_registration_image
 * @property string $original_car_registration_image
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \App\Car $car
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CarRegistration whereCarId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CarRegistration whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CarRegistration whereCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CarRegistration whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CarRegistration whereDateOfIssue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CarRegistration whereExpirationDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CarRegistration whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CarRegistration whereLicencePlate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CarRegistration whereOriginalCarRegistrationImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CarRegistration whereSmallCarRegistrationImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CarRegistration whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CarRegistration whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property int|null $expired
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CarRegistration whereExpired($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CarRegistration newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CarRegistration newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CarRegistration query()
 */
class CarRegistration extends Model
{
	/**
	 * @var string
	 */
	public $transformer = CarRegistrationTransformer::class;

	/**
	 * @var array
	 */
	protected $fillable = [
	    'country', 'state', 'city', 'licence_plate', 'expiration_date', 'date_issue'
    ];

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function car()
	{
		return $this->belongsTo(Car::class);
	}
}
