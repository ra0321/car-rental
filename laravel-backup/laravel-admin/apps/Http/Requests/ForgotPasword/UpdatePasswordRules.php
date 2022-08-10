<?php

namespace App\Http\Requests\ForgotPasword;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePasswordRules extends FormRequest
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
	        'new_password' => 'required|min:6',
	        'new_password_confirmation' => 'required|same:new_password'
        ];
    }
}
