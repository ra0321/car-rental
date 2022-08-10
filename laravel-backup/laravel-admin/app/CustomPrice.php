<?php

namespace App;

use App\Traits\Models\Mutators;
use App\Traits\Models\CustomMethods;
use App\Transformers\CustomPriceTransformer;
use Illuminate\Database\Eloquent\Model;

class CustomPrice extends Model
{
	protected $fillable = [
        'is_automatic_price','price', 'custom_price', 'price_from_date', 'price_until_date','discount_week', 'discount_month',
	];

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function car()
	{
		return $this->belongsTo(Car::class);
    }
}
