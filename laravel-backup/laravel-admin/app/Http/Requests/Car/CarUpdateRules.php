<?php

namespace App\Http\Requests\Car;

use App\AllCar;
use App\Car;
use App\Exceptions\CustomException;
use Carbon\Carbon;
use App\Rules\RealBool;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class CarUpdateRules
 * @package App\Http\Requests\Car
 */
class CarUpdateRules extends FormRequest
{

    /**
     * @return bool
     * @throws CustomException
     */
    public function authorize()
    {
        $user = $this->user();
        $thisCar = $this->route()->parameter('car');
        $car = Car::whereUserId($user->id)->where('phase', '!=', '100')->first();
        if($car->id !== $thisCar->id){
            throw new CustomException(YOU_CAN_NOT_HAVE_MORE_THEN_ONE_UNFINISHED_CARS);
        }
        return true;
    }

    /**
     * @return array
     * @throws CustomException
     */
    public function rules()
    {
        $request = $this->request->all();

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

        $now = Carbon::now()->dayOfYear > 270 ? (int)Carbon::now()->format('Y') + 1 : Carbon::now()->format('Y');
        $oldest = Carbon::now()->dayOfYear > 270 ? $now - 11 : $now - 10;

        $production_year = $request['production_year'];
        if(isset($request['car_odometer']) && isset($request['real_odometer'])){
            throw new CustomException(YOU_CAN_NOT_INPUT_ODOMETER_AND_REAL_ODOMETER);
        }
        if($production_year < 1990){

	        if($request['car_value'] > 300000){
		        throw new CustomException(THE_CAR_VALUE_MAY_NOT_BE_GREATER_THAN_300000);
	        }

            return [
                'long_location' => 'required|numeric',
                'lat_location' => 'required|numeric',
                'car_manufacturer' => 'required|exists:esar_cars,model_make_id',
                'car_model' => 'required|exists:esar_cars,model_name',
                'production_year' => 'required|numeric|min:1945',
                'trim' => 'string|nullable|exists:esar_cars,model_trim',
                'style' => 'string|nullable|exists:esar_cars,model_body',
                'car_transmission' => ['required', Rule::in(['automatic', 'manual'])],
                'brended' => ['required', new RealBool(BRANDED), Rule::in([true, 'true', 1])],
                'car_value' => 'required|integer|min:5000',
                'real_odometer' => 'required|numeric|min:1|max:999999'
            ];
        }
        return [
            'long_location' => 'required|numeric',
            'lat_location' => 'required|numeric',
            'car_manufacturer' => 'required|exists:esar_cars,model_make_id',
            'car_model' => 'required|exists:esar_cars,model_name',
            'production_year' => 'required|numeric|between:' . $oldest . ',' . (int)$now,
            'trim' => 'string|nullable|exists:esar_cars,model_trim',
            'style' => 'string|nullable|exists:esar_cars,model_body',
            'car_transmission' => ['required', Rule::in(['automatic', 'manual'])],
            'brended' => ['required', new RealBool(BRANDED), Rule::in([true, 'true', 1])],
            'car_value' => 'required|integer|max:500000|min:5000',
            'car_odometer' => ['required', Rule::in(['0-70k KM', '70k-140k KM', '140k-210k KM', '210k-250k KM'])],
        ];
    }
}
