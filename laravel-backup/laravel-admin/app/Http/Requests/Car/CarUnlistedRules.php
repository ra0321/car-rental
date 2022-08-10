<?php

namespace App\Http\Requests\Car;

use App\CarUnlisted;
use App\Exceptions\CustomException;
use Carbon\Carbon;
use App\Rules\RealBool;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class CarUnlistedRules
 * @package App\Http\Requests\Car
 */
class CarUnlistedRules extends FormRequest
{

	/**
	 * @return bool
	 * @throws CustomException
	 */
	public function authorize()
    {
	    $car = $this->route('car');
    	$request = $this->request->all();
    	$status = $request['car_status'];
    	$unlisted = CarUnlisted::whereCarId($car->id)->orderBy('id', 'desc')->first();
    	if($unlisted !== null && $unlisted->car_status === $status){
    		switch($status){
			    case('listed'):
				    throw new CustomException(YOUR_CAR_IS_ALREADY_LISTED);
				    break;
			    case('snoozed'):
				    throw new CustomException(YOUR_CAR_IS_ALREADY_SNOOZED);
				    break;
			    case('unlisted'):
				    throw new CustomException(YOUR_CAR_IS_ALREADY_UNLISTED);
				    break;
			    case('deleted'):
				    throw new CustomException(YOUR_CAR_IS_ALREADY_DELETED);
				    break;
		    }
	    }
        return true;
    }


    /**
     * @return array
     * @throws CustomException
     */
    public function rules()
    {
    	$start_date = Carbon::now();
    	$end_date = Carbon::now()->addMonths(6);
    	$rules = [];

    	if($this->input('car_status') === 'snoozed'){
		    $input_start_date = Carbon::parse($this->input('start_date'));
    		$input_end_date = Carbon::parse($this->input('end_date'));

    		if($input_end_date->lte($input_start_date)){
                throw new CustomException(END_DATE_MUST_BE_AFTER_START_DATE);
		    }
    	    $rules['start_date'] = 'required|date|after:' . $start_date;
    	    $rules['end_date'] = 'required|date|before:' . $end_date;
	    }
	    if($this->input('car_status') === 'unlisted'){
		    $rules['have_no_car'] = ['nullable', new RealBool(HAVE_NO_CAR)];
		    $rules['safety_concerns'] = ['nullable', new RealBool(SAFETY_CONCERNS)];
		    $rules['not_earning_enough'] = ['nullable', new RealBool(NOT_EARNING_ENOUGH)];
		    $rules['too_much_work'] = ['nullable', new RealBool(TOO_MUCH_WORK)];
		    $rules['negative_experience'] = ['nullable', new RealBool(NEGATIVE_EXPERIENCE)];
		    $rules['other_reason'] = ['nullable', new RealBool(OTHER_REASON)];
		    $rules['feedback'] = 'string|max:1000|nullable';
	    }
	    if($this->input('car_status') === 'deleted'){
		    $rules['have_no_car'] = ['nullable', new RealBool(HAVE_NO_CAR)];
		    $rules['safety_concerns'] = ['nullable', new RealBool(SAFETY_CONCERNS)];
		    $rules['not_earning_enough'] = ['nullable', new RealBool(NOT_EARNING_ENOUGH)];
		    $rules['too_much_work'] = ['nullable', new RealBool(TOO_MUCH_WORK)];
		    $rules['negative_experience'] = ['nullable', new RealBool(NEGATIVE_EXPERIENCE)];
		    $rules['other_reason'] = ['nullable', new RealBool(OTHER_REASON)];
		    $rules['feedback'] = 'string|max:1000|nullable';
	    }
        return $rules;
    }
}
