<?php

namespace App\Http\Requests\Profile;

use App\Exceptions\CustomException;
use App\Profile;
use App\Traits\DateVerification;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class ProfileUpdateDriversLicenceRules
 * @package App\Http\Requests\Profile
 */
class ProfileUpdateDriversLicenceRules extends FormRequest
{
	use DateVerification;
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
    	//$request = $this->all();
    	$now = Carbon::now();
	    /*$user_id = $this->route('id');
    	$profile = Profile::where('user_id', $user_id)->firstOrFail();
    	$request['middle_name'] = isset($request['middle_name']) ? $request['middle_name'] : null;*/

    	/*if(isset($profile->first_name) && $profile->first_name !== $request['first_name']){
            throw new CustomException(FIRST_NAME_ON_ID_CARD_AND_ON_DRIVER_LICENCE_MUST_BE_THE_SAME);
        }

    	if(isset($profile->last_name) && $profile->last_name !== $request['last_name']){
            throw new CustomException(LAST_NAME_ON_ID_CARD_AND_ON_DRIVER_LICENCE_MUST_BE_THE_SAME);
        }

    	if(isset($profile->middle_name) && $profile->middle_name !== $request['middle_name']){
            throw new CustomException(MIDDLE_NAME_ON_ID_CARD_AND_ON_DRIVER_LICENCE_MUST_BE_THE_SAME);
        }

        if(isset($request['dayOB']) && isset($request['monthOB']) && isset($request['yearOB'])){
            $this->checkDateFromArray($request);
            $dob = $this->createDateFromArray($request);
            if(isset($profile->dob) && $dob !== $profile->dob){
                throw new CustomException(DATE_OF_BIRTH_ON_ID_CARD_AND_ON_DRIVER_LICENCE_MUST_BE_THE_SAME);
            }
        }else{
            throw new CustomException(DATE_OF_BIRTH_MUST_BE_A_VALID_DATE);
        }*/

    	/*if(isset($profile['id_number'])){
		    if($profile['first_name'] !== $request['first_name']){
                throw new CustomException(FIRST_NAME_ON_ID_CARD_AND_ON_DRIVER_LICENCE_MUST_BE_THE_SAME);
		    }
		    if($profile['last_name'] !== $request['last_name']){
                throw new CustomException(LAST_NAME_ON_ID_CARD_AND_ON_DRIVER_LICENCE_MUST_BE_THE_SAME);
		    }
		    if(isset($profile['middle_name'])){
			    if($profile['middle_name'] !== $request['middle_name']){
                    throw new CustomException(MIDDLE_NAME_ON_ID_CARD_AND_ON_DRIVER_LICENCE_MUST_BE_THE_SAME);
			    }
		    }
		    if(isset($request['dayOB']) && isset($request['monthOB']) && isset($request['yearOB'])){
			    $this->checkDateFromArray($request);
			    $dob = $this->createDateFromArray($request);
			    if($dob !== $profile['dob']){
                    throw new CustomException(DATE_OF_BIRTH_ON_ID_CARD_AND_ON_DRIVER_LICENCE_MUST_BE_THE_SAME);
			    }
		    }else{
                throw new CustomException(DATE_OF_BIRTH_MUST_BE_A_VALID_DATE);
		    }
		    if($profile['id_country'] !== $request['id_country']){
                throw new CustomException(COUNTRY_ON_ID_CARD_AND_ON_DRIVER_LICENCE_MUST_BE_THE_SAME);
		    }
		    if($profile['id_state'] !== $request['id_state']){
                throw new CustomException(STATE_ON_ID_CARD_AND_ON_DRIVER_LICENCE_MUST_BE_THE_SAME);
		    }
		    if($profile['id_city'] !== $request['id_city']){
                throw new CustomException(CITY_ON_ID_CARD_AND_ON_DRIVER_LICENCE_MUST_BE_THE_SAME);
		    }
		    return [
			    'driver_licence_image_path' => 'required|image|mimes:jpeg,jpg,png,JPG|dimensions:min_width=640,min_height=320',
                'driver_licence_expiration_date' => 'required|date|after:' . $now->addDays(15),
                'driver_licence_number' => 'required|string|digits:10',
                'driver_licence_date_of_issue' => 'required|date|before:' . Carbon::now(),
		    ];
	    }*/
        return [
	        'first_name' => 'string|max:30',
	        'last_name' => 'string|max:30',
	        'middle_name' => 'string|max:30|nullable',
	        'dayOB' => 'numeric|min:1|max:31',
	        'monthOB' => 'numeric|min:1|max:12',
	        'yearOB' => 'numeric|min:1945|max:1999',
            'id_country' => 'string|nullable',
            'id_state' => 'string|nullable',
            'id_city' => 'string|nullable',
            'driver_licence_expiration_date' => 'date|after:' . $now->addDays(15),
	        'driver_licence_image_path' => 'required|image|mimes:jpeg,jpg,png,JPG|dimensions:min_width=640,min_height=320',
            /*'driver_licence_number' => 'required|string|digits:10',
            'driver_licence_date_of_issue' => 'required|date|before:' . Carbon::now(),*/
        ];
    }
}
