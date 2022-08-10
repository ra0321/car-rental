<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SocialConnectRules extends FormRequest
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
            'first_name' => 'string|max:30|nullable',
            'last_name' => 'string|max:30|nullable',
            'email' => 'string|max:255|nullable',
            'social_id' => 'required',
            'friends_count' => 'numeric',
            'picture_url' => 'string',
            'connection_type' => ['required', Rule::in(['facebook', 'google'])]
        ];
    }
}
