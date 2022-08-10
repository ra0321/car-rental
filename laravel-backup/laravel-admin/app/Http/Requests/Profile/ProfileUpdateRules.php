<?php

namespace App\Http\Requests\Profile;

use Illuminate\Foundation\Http\FormRequest;

class ProfileUpdateRules extends FormRequest
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
	        'works' => 'string|max:255|nullable',
	        'address' => 'string|max:255|nullable',
	        'school' => 'string|max:255|nullable',
	        'language' => 'string|max:255|nullable',
	        'about_me' => 'string|max:1000|nullable',
        ];
    }
}
