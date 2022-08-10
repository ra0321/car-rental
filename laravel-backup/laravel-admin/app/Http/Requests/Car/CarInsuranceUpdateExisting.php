<?php

namespace App\Http\Requests\Car;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class CarInsuranceUpdateExisting extends FormRequest
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
    	$now = Carbon::now();
        return [
	        'policy_number' => 'string',
	        'detectable_amount' => 'numeric|max:10000',
	        'policy_card_image' => 'image|mimes:jpeg,png,jpg,JPG|dimensions:min_width=640,min_height=320',
	        'date_of_issue' => 'date|before:' . Carbon::now(),
	        'expiration_date' => 'date|after:' . $now->addDays(15),
        ];
    }
}
