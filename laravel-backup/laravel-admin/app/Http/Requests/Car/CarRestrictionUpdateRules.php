<?php

namespace App\Http\Requests\Car;

use App\CarRestriction;
use App\Exceptions\CustomException;
use App\Traits\ValueTransform;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * Class CarRestrictionUpdateRules
 * @package App\Http\Requests\Car
 */
class CarRestrictionUpdateRules extends FormRequest
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
        $data = $this->request->all();
        $distance = CarRestriction::findOrFail($data['id']);
        $carRestriction['km_per_day'] = isset($data['km_per_day']) ? $data['km_per_day'] : $distance->km_per_day;
        $carRestriction['km_per_week'] = isset($data['km_per_week']) ? $data['km_per_week'] : $distance->km_per_week;
        $carRestriction['km_per_month'] = isset($data['km_per_month']) ? $data['km_per_month'] : $distance->km_per_month;
        $carRestriction['price_per_km'] = isset($data['price_per_km']) ? $data['km_per_month'] : $distance->price_per_km;
        if($carRestriction['km_per_day'] === 'unlimited' && $carRestriction['km_per_week'] === 'unlimited' && $carRestriction['km_per_month'] === 'unlimited'){
            return [
                'price_per_km' => 'nullable',
            ];
        }
        if($carRestriction['km_per_day'] !== 'unlimited' || $carRestriction['km_per_week'] !== 'unlimited' || $carRestriction['km_per_month'] !== 'unlimited'){
            if($carRestriction['price_per_km'] === null || $carRestriction['price_per_km'] === 0){
                throw new CustomException(YOU_DID_NOT_PROVIDE_PRICE_FOR_ADDITIONAL_DISTANCES);
            }
        }
        $kmPerDay = $this->kmPerDay($carRestriction['km_per_day']);
        $kmPerWeek = $this->kmPerWeek($carRestriction['km_per_week']);
        $kmPerMonth = $this->kmPerMonth($carRestriction['km_per_month']);
        if($kmPerWeek < ($kmPerDay * 7)){
            throw new CustomException(KM_PER_WEEK_MUST_BE_AT_LEAST);
        }
        if($kmPerMonth < ($kmPerDay * 30)){
            throw new CustomException(KM_PER_MONTH_MUST_BE_AT_LEAST);
        }

        return [
            'km_per_day' => Rule::in(['100', '200', '300', '400', 'unlimited']),
            'km_per_week' => Rule::in(['700', '1400', '2100', '2800', 'unlimited']),
            'km_per_month' => Rule::in(['3000', '6000', '9000', '12000', 'unlimited']),
            'price_per_km' => 'numeric|max:3',
        ];
    }
}
