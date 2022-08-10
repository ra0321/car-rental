<?php

namespace App\Http\Requests\Verify;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class VerifyUpdatedPhoneRules
 * @package App\Http\Requests\Verify
 */
class VerifyUpdatedPhoneRules extends FormRequest
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
		    'sms_code' => 'required',
	    ];
    }
}
