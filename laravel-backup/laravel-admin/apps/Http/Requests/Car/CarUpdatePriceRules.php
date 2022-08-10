<?php

namespace App\Http\Requests\Car;

use App\Rules\RealBool;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CarUpdatePriceRules extends FormRequest
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
        return [
	        'is_automatic_price' => ['required', new RealBool(IS_AUTOMATIC_PRICE)],
	        'price' => 'integer|max:10000|min:10',
	        'discount_week' => ['numeric', Rule::in(0, 5, 10, 15)],
	        'discount_month' => ['numeric', Rule::in(0, 5, 10, 15, 20, 25)]
        ];
    }
}
