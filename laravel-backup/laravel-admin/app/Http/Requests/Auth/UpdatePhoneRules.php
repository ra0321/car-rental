<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class UpdatePhoneRules
 * @package App\Http\Requests\Auth
 */
class UpdatePhoneRules extends FormRequest
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
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
	    return [
		    'phone' => 'required|numeric',
		    'country_code' => 'required|numeric'
	    ];
    }
}
