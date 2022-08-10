<?php

namespace App\Http\Requests\Auth;

use App\Exceptions\CustomException;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class RegistrationRules
 * @package App\Http\Requests\Auth
 */
class RegistrationRules extends FormRequest
{
	protected function getValidatorInstance()
	{
		return parent::getValidatorInstance();
	}

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
            'first_name' => 'required|max:30',
            'last_name' => 'required|max:30',
            'email' => 'required|unique:users,email',
            'password' => 'required|min:6',
        ];
    }
}
