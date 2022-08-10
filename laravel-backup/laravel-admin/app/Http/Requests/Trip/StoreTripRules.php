<?php

namespace App\Http\Requests\Trip;

use App\Exceptions\CustomException;
use App\Traits\CheckDocument;
use App\User;
use Carbon\Carbon;
use App\Rules\RealBool;
use App\Models\Traits\Mutators;
use Illuminate\Validation\Rule;
use App\Traits\TokenAuthorization;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class StoreTripRules
 * @package App\Http\Requests\Trip
 */
class StoreTripRules extends FormRequest
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

	    /*$this->checkDriverLicence($user);
	    $this->checkId($user);
	    $owner = User::findOrFail($car->user_id);
	    $this->isOwnerIdVerified($owner);*/


	    $this->isCarDeleted($car);
	    $this->isCarRegistrationVerified($car);
	    $this->isCarInsuranceVerified($car);

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
        $now = Carbon::now();
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
            'price_from_date' => 'required|date|after:' . $now->format('Y-m-d H:i:s'),
            'price_until_date' => 'required|date|after:price_from_date',
            'pick_on_airport' => 'required',
            'airport_id' => 'required_if:pick_on_airport,true|numeric',
            'pick_on_car_location' => 'required',
            'pick_on_guest_location' => 'required',
            'long_location' => 'required_if:pick_on_guest_location,true|numeric',
            'lat_location' => 'required_if:pick_on_guest_location,true|numeric',
            'i_agree' => ['required', new RealBool(I_AGREE), Rule::in(true, 'true', 1)],
            'message' => 'required'
        ];
    }
}
