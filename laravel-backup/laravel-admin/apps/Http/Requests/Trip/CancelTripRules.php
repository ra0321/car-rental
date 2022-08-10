<?php

namespace App\Http\Requests\Trip;

use App\Exceptions\CustomException;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpKernel\Exception\HttpException;

/**
 * Class CancelTripRules
 * @package App\Http\Requests\Trip
 */
class CancelTripRules extends FormRequest
{

    /**
     * @return bool
     * @throws CustomException
     */
    public function authorize()
    {
        $car = $this->route()->parameter('trip');
        $user = $this->user();
        if($user['id'] !== $car->owner_id){
            throw new CustomException(YOU_CAN_NOT_CANCEL_THIS_TRIP);
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
            //
        ];
    }
}
