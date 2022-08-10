<?php

namespace App\Http\Requests\Car;

use Carbon\Carbon;
use App\Traits\TokenAuthorization;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class CarStoreUnavailability
 * @package App\Http\Requests\Car
 */
class CarStoreUnavailability extends FormRequest
{
    use TokenAuthorization;

	/**
	 * @return bool
	 * @throws \App\Exceptions\CustomException
	 */
	public function authorize()
    {
        $user = $this->user();
        $car = $this->route()->parameter('car');
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
