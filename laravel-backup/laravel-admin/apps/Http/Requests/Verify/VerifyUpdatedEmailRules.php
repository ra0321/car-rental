<?php

namespace App\Http\Requests\Verify;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class VerifyUpdatedEmailRules
 * @package App\Http\Requests\Verify
 */
class VerifyUpdatedEmailRules extends FormRequest
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
	        'verify_token' => 'required'
        ];
    }
}
