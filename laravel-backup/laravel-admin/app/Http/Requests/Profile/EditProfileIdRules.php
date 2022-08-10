<?php

namespace App\Http\Requests\Profile;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class EditProfileIdRules extends FormRequest
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
	    $minYear = $now->subYears(21)->format('Y');
        return [
	        'first_name' => 'string|max:30',
	        'last_name' => 'string|max:30',
	        'middle_name' => 'string|max:30|nullable',
	        'dayOB' => 'required_with:monthOB,yearOB|numeric|min:1|max:31',
	        'monthOB' => 'required_with:dayOB,yearOB|numeric|min:1|max:12',
	        'yearOB' => 'required_with:monthOB,dayOB|numeric|min:1945|max:' . $minYear,
	        'id_country' => 'string|nullable',
	        'id_state' => 'string|nullable',
	        'id_city' => 'string|nullable',
	        'id_image' => 'image|mimes:jpeg,jpg,png,JPG|dimensions:min_width=640,min_height=320',
	        'expiration_date' => 'date|after:' . $now->addDays(15),
            /*'date_of_issue' => 'date|before:' . Carbon::now(),
            'id_number' => 'digits:10',
	        'issued_by' => 'string'*/
        ];
    }
}
