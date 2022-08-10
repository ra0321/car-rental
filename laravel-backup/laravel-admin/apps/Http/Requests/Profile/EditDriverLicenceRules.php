<?php

namespace App\Http\Requests\Profile;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class EditDriverLicenceRules extends FormRequest
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
	        'driver_licence_image_path' => 'image|mimes:jpeg,jpg,png,JPG|dimensions:min_width=640,min_height=320',
	        'driver_licence_expiration_date' => 'date|after:' . $now->addDays(15),
            /*'driver_licence_number' => 'string|digits:10',
            'driver_licence_date_of_issue' => 'date|before:' . Carbon::now(),*/
        ];
    }
}
