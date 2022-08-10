<?php

namespace App\Http\Requests\Chat;

use App\Chat;
use App\Exceptions\CustomException;
use App\Traits\TokenAuthorization;
use App\User;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class SendNewMessageRules
 * @package App\Http\Requests\Chat
 */
class SendNewMessageRules extends FormRequest
{
    use TokenAuthorization;

    /**
     * @return bool
     * @throws CustomException
     */
    public function authorize()
    {
        $request = $this->request->all();
        $chat = Chat::findOrFail($request['chat_id']);
        if($this->user()->id === $chat['renter_id']){
        	$receiver = User::findOrFail($chat['owner_id']);
        	if($receiver['user_active_status'] == 0){
        		throw new CustomException(SORRY_YOU_CANNOT_SEND_A_MESSAGE_TO_THIS_USER_THIS_USER_WAS_DELETED);
	        }
        }else{
	        $receiver = User::findOrFail($chat['renter_id']);
	        if($receiver['user_active_status'] == 0){
		        throw new CustomException(SORRY_YOU_CANNOT_SEND_A_MESSAGE_TO_THIS_USER_THIS_USER_WAS_DELETED);
	        }
        }
        if($this->user()->id === $chat['renter_id'] || $this->user()->id === $chat['owner_id']){
            return true;
        }
        throw new CustomException(YOU_CAN_NOT_WRITE_MESSAGE_IN_THIS_CHAT);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'chat_id' => 'required',
            'message' => 'required_without:image',
            'image' => 'required_without:message|image|mimes:jpeg,png,jpg,JPG',
        ];
    }
}
