<?php

namespace App\Http\Requests\Car;

use App\Exceptions\CustomException;
use App\Traits\ValueTransform;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class CarUpdateNoticeRules
 * @package App\Http\Requests\Car
 */
class CarUpdateNoticeRules extends FormRequest
{
    use ValueTransform;
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * @return array
     * @throws CustomException
     */
    public function rules()
    {
        $short_trip = $this->shortestTrip($this->request->get('short_trip'));
        $long_trip = $this->longestTrip($this->request->get('long_trip'));
        if($short_trip > $long_trip){
            throw new CustomException(SHORTEST_TRIP_MUST_BE_SHORTER_THAN_LONGEST_TRIP);
        }
        return [
	        'notice' => ['required', Rule::in(['1 hour', '2 hours', '3 hours', '6 hours', '12 hours', '1 day', '2 days', '3 days', '1 week'])],
	        'short_trip' => ['required', Rule::in(['Any', '1 day', '2 days', '3 days', '5 days', '1 week', '2 weeks', '1 month'])],
	        'long_trip' => ['required', Rule::in(['3 days', '5 days', '1 week', '2 weeks', '1 month', '3 months', 'Any'])],
        ];
    }
}
