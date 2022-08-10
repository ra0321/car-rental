<?php

namespace App\Http\Requests\Trip;

use App\Exceptions\CustomException;
use App\Models\Traits\Mutators;
use App\Traits\CheckDocument;
use App\Traits\TokenAuthorization;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class TripCalculatorRules
 * @package App\Http\Requests\Trip
 */
class TripCalculatorRules extends FormRequest
{
    use TokenAuthorization, Mutators, CheckDocument;

    /**
     * @return bool
     * @throws CustomException
     */
    public function authorize()
    {
        $user = $this->authenticateUserByToken();

        $car = $this->route()->parameter('car');

	    /*$owner = User::findOrFail($car->user_id);
	    $this->isOwnerIdVerified($owner);*/

	    $this->isCarDeleted($car);
	    $this->isCarRegistrationVerified($car);
	    $this->isCarInsuranceVerified($car);
	    $this->checkAdvanceNotice($car, $this->request->all());

        $pass = $car->user_id === $user->id ? false : true;
        if($pass === true){
            return $pass;
        }else{
            throw new CustomException(UNAUTHORIZED_YOU_CAN_NOT_RENT_YOUR_CAR);
        }

    }

    /**
     * @return array
     * @throws CustomException
     */
    public function rules()
    {
        $request = $this->request->all();
        if(Carbon::now()->gte(Carbon::parse($request['price_from_date']))){
        	throw new CustomException(DATE_MUST_BE_AFTER_CURRENT_TIME);
        }
        $pick_on_airport = $this->changeToBool($request['pick_on_airport']);
        $pick_on_car_location = $this->changeToBool($request['pick_on_car_location']);
        $pick_on_guest_location = $this->changeToBool($request['pick_on_guest_location']);
        switch($request){
            case($pick_on_airport === true):
                if($pick_on_airport === $pick_on_car_location || $pick_on_airport === $pick_on_guest_location){
                    throw new CustomException(YOU_MUST_CHOOSE_ONLY_ONE_LOCATION);
                }
                break;
            case($pick_on_car_location === true):
                if($pick_on_car_location === $pick_on_airport || $pick_on_car_location === $pick_on_guest_location){
                    throw new CustomException(YOU_MUST_CHOOSE_ONLY_ONE_LOCATION);
                }
                break;
            case($pick_on_guest_location === true):
                if($pick_on_guest_location === $pick_on_airport || $pick_on_guest_location === $pick_on_car_location){
                    throw new CustomException(YOU_MUST_CHOOSE_ONLY_ONE_LOCATION);
                }
                break;
            default:
                throw new CustomException(YOU_MUST_CHOOSE_AT_LEAST_ONE_LOCATION);
        }
        return [
            'price_from_date' => 'required|date',
            'price_until_date' => 'required|date|after:price_from_date',
            'pick_on_airport' => 'required',
            'airport_id' => 'required_if:pick_on_airport,true|numeric',
            'pick_on_car_location' => 'required',
            'pick_on_guest_location' => 'required',
            'long_location' => 'required_if:pick_on_guest_location,true|numeric',
            'lat_location' => 'required_if:pick_on_guest_location,true|numeric',
            'promo_code' => 'alpha_num|nullable|max:10'
        ];
    }
}
