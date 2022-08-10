<?php

namespace App\Http\Requests\Car;

use App\Car;
use Carbon\Carbon;
use App\CarAvailable;
use App\Traits\TokenAuthorization;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class CarUpdateUnavailability
 * @package App\Http\Requests\Car
 */
class CarUpdateUnavailability extends FormRequest
{
    use TokenAuthorization;

	/**
	 * @return bool
	 * @throws \App\Exceptions\CustomException
	 */
	public function authorize()
    {
        $user = $this->user();
        $id = $this->route()->parameter('id');
        $unavailable = CarAvailable::findOrFail($id);
        $car = Car::findOrFail($unavailable['car_id']);
        $this->checkUser($user->id, $car);
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
            'unavailable_from' => 'required|after:' . $now,
            'unavailable_until' => 'required|after:unavailable_from'
        ];
    }
}
