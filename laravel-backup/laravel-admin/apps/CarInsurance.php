<?php

namespace App;

use App\Transformers\CarInsuranceTransformer;
use Illuminate\Database\Eloquent\Model;

/**
 * Class CarInsurance
 *
 * @package App
 * @property int $id
 * @property int $car_id
 * @property string $policy_number
 * @property string $detectable_amount
 * @property string|null $expiration_date
 * @property string|null $date_of_issue
 * @property string $image_policy_card
 * @property string $small_image_policy_card
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \App\Car $car
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CarInsurance whereCarId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CarInsurance whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CarInsurance whereDateOfIssue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CarInsurance whereDetectableAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CarInsurance whereExpirationDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CarInsurance whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CarInsurance whereImagePolicyCard($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CarInsurance wherePolicyNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CarInsurance whereSmallImagePolicyCard($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CarInsurance whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property int|null $expired
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CarInsurance whereExpired($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CarInsurance newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CarInsurance newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CarInsurance query()
 */
class CarInsurance extends Model
{

	/**
	 * @var string
	 */
	public $transformer = CarInsuranceTransformer::class;

	/**
	 * @var array
	 */
	protected $fillable = [
	    'policy_number', 'detectable_amount', 'policy_card_image'
    ];

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function car()
	{
		return $this->belongsTo(Car::class);
	}
}
