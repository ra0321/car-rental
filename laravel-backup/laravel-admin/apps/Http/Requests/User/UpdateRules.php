<?php

namespace App\Http\Requests\User;

use App\Rules\RealBool;
use Illuminate\Foundation\Http\FormRequest;

class UpdateRules extends FormRequest
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
	        'sms_notifications' => [new RealBool(SMS_NOTIFICATIONS)],
	        'email_promotions' => [new RealBool(EMAIL_PROMOTIONS)],
	        'transmission_expert' => [new RealBool(TRANSMISSION_EXPERT)],
        ];
    }
}
