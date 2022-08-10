<?php

namespace App\Http\Requests\Car;

use App\AllCar;
use App\Exceptions\CustomException;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * Class RentalCalculatorRules
 * @package App\Http\Requests\Car
 */
class RentalCalculatorRules extends FormRequest
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
	 * @return array
	 * @throws CustomException
	 */
	public function rules()
    {
	    $request = $this->request->all();

	    $email = isset($request['email']) ? $request['email'] : null;
	    if($email){
		    $is_email = filter_var($email, FILTER_VALIDATE_EMAIL);
		    if(!$is_email){
			    throw new CustomException(THE_EMAIL_MUST_BE_A_VALID_EMAIL_ADDRESS);
		    }
	    }

	    $phone = isset($request['phone']) ? $request['phone'] : null;
	    if(filter_var($phone, FILTER_SANITIZE_NUMBER_INT) !== str_replace(' ', '', $phone)){
		    throw new CustomException(PLEASE_ENTER_VALID_PHONE_NUMBER);
	    }
	    if(strpos($phone, '-') !== false){
		    throw new CustomException(PLEASE_ENTER_VALID_PHONE_NUMBER);
	    }
	    if(strpos($phone, '+') !== 0){
		    throw new CustomException(PLEASE_ENTER_VALID_PHONE_NUMBER);
	    }
	    if(substr_count($phone, '+') > 1){
		    throw new CustomException(PLEASE_ENTER_VALID_PHONE_NUMBER);
	    }

	    if(isset($request['trim'])){
		    if(isset($request['style'])){
			    $car_model = AllCar::where('model_make_id', $request['car_manufacturer'])
			                       ->where('model_name', $request['car_model'])
			                       ->where('model_year', $request['production_year'])
			                       ->where('model_transmission_type', $request['car_transmission'])
			                       ->where('model_trim', $request['trim'])
			                       ->where('model_body', $request['style'])
			                       ->firstOrFail();
		    }else{
			    $car_model = AllCar::where('model_make_id', $request['car_manufacturer'])
			                       ->where('model_name', $request['car_model'])
			                       ->where('model_year', $request['production_year'])
			                       ->where('model_transmission_type', $request['car_transmission'])
			                       ->where('model_trim', $request['trim'])
			                       ->firstOrFail();
		    }
	    }elseif (isset($request['style'])){
		    $car_model = AllCar::where('model_make_id', $request['car_manufacturer'])
		                       ->where('model_name', $request['car_model'])
		                       ->where('model_year', $request['production_year'])
		                       ->where('model_transmission_type', $request['car_transmission'])
		                       ->where('model_body', $request['style'])
		                       ->firstOrFail();
	    }else{
		    $car_model = AllCar::where('model_make_id', $request['car_manufacturer'])
		                       ->where('model_name', $request['car_model'])
		                       ->where('model_year', $request['production_year'])
		                       ->where('model_transmission_type', $request['car_transmission'])
		                       ->firstOrFail();
	    }


	    if($car_model->id != $request['car_model_id']){
		    throw new CustomException(SOMETHING_WRONG_WITH_DATA_OF_CAR);
	    }

	    $now = Carbon::now()->format('Y');
	    $oldest = $now - 10;
	    $production_year = $request['production_year'];
	    if(isset($request['car_odometer']) && isset($request['real_odometer'])){
		    throw new CustomException(YOU_CAN_NOT_INPUT_ODOMETER_AND_REAL_ODOMETER);
	    }
	    if($production_year < 1990){

		    if($request['car_value'] > 300000){
			    throw new CustomException(THE_CAR_VALUE_MAY_NOT_BE_GREATER_THAN_300000);
		    }

		    return [
			    'email' => 'required',
			    'phone' => 'required',
			    'car_manufacturer' => 'required|exists:esar_cars,model_make_id',
			    'car_model' => 'required|exists:esar_cars,model_name',
			    'production_year' => 'required|numeric|min:1945',
			    'trim' => 'string|nullable|exists:esar_cars,model_trim',
			    'style' => 'string|nullable|exists:esar_cars,model_body',
			    'car_transmission' => ['required', Rule::in(['automatic', 'manual'])],
			    'car_value' => 'required|integer|min:5000',
			    'real_odometer' => 'required|numeric|min:1|max:999999'
		    ];
	    }
	    return [
		    'email' => 'required',
		    'phone' => 'required',
		    'car_manufacturer' => 'required|exists:esar_cars,model_make_id',
		    'car_model' => 'required|exists:esar_cars,model_name',
		    'production_year' => 'required|numeric|between:' . $oldest . ',' . (int)$now,
		    'trim' => 'string|nullable|exists:esar_cars,model_trim',
		    'style' => 'string|nullable|exists:esar_cars,model_body',
		    'car_transmission' => ['required', Rule::in(['automatic', 'manual'])],
		    'car_value' => 'required|integer|max:500000|min:5000',
		    'car_odometer' => ['required', Rule::in(['0-70k KM', '70k-140k KM', '140k-210k KM', '210k-250k KM'])],
	    ];
    }
}
