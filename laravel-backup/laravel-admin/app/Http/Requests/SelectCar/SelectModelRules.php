<?php

namespace App\Http\Requests\SelectCar;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class SelectModelRules
 * @package App\Http\Requests\SelectCar
 */
class SelectModelRules extends FormRequest
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
	 */
	public function rules()
    {
        return [
            'manufacturer' => 'exists:esar_cars,model_make_id',
            'model' => 'exists:esar_cars,model_name',
            'transmission' => 'exists:esar_cars,model_transmission_type',
            'year' => 'required'
        ];
    }
}
