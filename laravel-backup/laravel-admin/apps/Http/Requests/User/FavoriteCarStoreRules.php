<?php

namespace App\Http\Requests\User;

use App\Exceptions\CustomException;
use App\FavoriteCar;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class FavoriteCarStoreRules
 * @package App\Http\Requests\User
 */
class FavoriteCarStoreRules extends FormRequest
{

    /**
     * @return bool
     * @throws CustomException
     */
    public function authorize()
    {

    	$user = $this->user()->id;
    	$car = $this->request->get('car_id');
    	$favorite = FavoriteCar::where(['user_id' => $user, 'car_id' => $car])->first();
    	if($favorite){
            throw new CustomException(THIS_CAR_IS_ALREADY_IN_LIST_OF_YOUR_FAVORITE_CARS);
	    }
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
            'car_id' => 'required|exists:cars,id'
        ];
    }
}
