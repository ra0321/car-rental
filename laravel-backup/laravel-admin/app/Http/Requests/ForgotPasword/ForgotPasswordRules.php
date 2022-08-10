<?php

namespace App\Http\Requests\ForgotPasword;

use App\Exceptions\CustomException;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class ForgotPasswordRules
 * @package App\Http\Requests\ForgotPasword
 */
class ForgotPasswordRules extends FormRequest
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
	 * @throws CustomException
	 */
	public function rules()
    {
	    $data = $this->request->all();
	    $email = isset($data['email']) ? $data['email'] : null;
	    if($email){
		    $is_email = filter_var($email, FILTER_VALIDATE_EMAIL);
		    if(!$is_email){
			    throw new CustomException(THE_EMAIL_MUST_BE_A_VALID_EMAIL_ADDRESS);
		    }
	    }
        return [
	        'email' => 'required',
        ];
    }
}
