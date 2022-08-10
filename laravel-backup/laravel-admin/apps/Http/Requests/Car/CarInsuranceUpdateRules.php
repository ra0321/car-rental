<?php

namespace App\Http\Requests\Car;

use Illuminate\Foundation\Http\FormRequest;

class CarInsuranceUpdateRules extends FormRequest
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
            'policy_card_image' => 'image|mimes:jpeg,png,jpg|dimensions:min_width=640,min_height=320',
            'policy_number' => 'string',
            'detectable_amount' => 'numeric|max:10000'
        ];
    }
}
