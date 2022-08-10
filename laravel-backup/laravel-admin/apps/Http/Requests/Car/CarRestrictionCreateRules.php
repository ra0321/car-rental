<?php

namespace App\Http\Requests\Car;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class CarRestrictionCreateRules extends FormRequest
{
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
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $data = $this->request->all();
        $carRestriction['km_per_day'] = isset($data['km_per_day']) ? $data['km_per_day'] : null;
        $carRestriction['km_per_week'] = isset($data['km_per_week']) ? $data['km_per_week'] : null;
        $carRestriction['km_per_month'] = isset($data['km_per_month']) ? $data['km_per_month'] : null;
        if($carRestriction['km_per_day'] === 'unlimited' && $carRestriction['km_per_week'] === 'unlimited' && $carRestriction['km_per_month'] === 'unlimited'){
            return [
                'price_per_km' => 'nullable',
            ];
        }
        return [
	        'km_per_day' => Rule::in(['100', '200', '300', '400', 'unlimited']),
	        'km_per_week' => Rule::in(['700', '1400', '2100', '2800', 'unlimited']),
	        'km_per_month' => Rule::in(['3000', '6000', '9000', '12000', 'unlimited']),
            'price_per_km' => 'numeric|required_with:km_per_day,km_per_week,km_per_month|max:3',
        ];
    }
}
