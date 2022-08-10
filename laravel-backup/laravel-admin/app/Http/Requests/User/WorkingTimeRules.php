<?php

namespace App\Http\Requests\User;

use App\Exceptions\CustomException;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class WorkingTimeRules
 * @package App\Http\Requests\User
 */
class WorkingTimeRules extends FormRequest
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
        $from_string = $this->request->get('from_time');
        $until_string = $this->request->get('until_time');
        if(isset($from_string)){
            try{
                $from = Carbon::parse($this->request->get('from_time'));
            }catch (\Exception $exception){
                throw new CustomException(FROM_FIELD_IS_NOT_CORRECT_TIME_FORMAT);
            }
        }

        if(isset($until_string)){
            try{
                $until = Carbon::parse($this->request->get('until_time'));
            }catch (\Exception $exception){
                throw new CustomException(UNTIL_FIELD_IS_NOT_CORRECT_TIME_FORMAT);
            }
        }

        if($from->gt($until) || $from->eq($until)){
            throw new CustomException(UNTIL_TIME_MUST_BE_AFTER_FROM_TIME);
        }

        return [
            'from_time' => 'required',
            'until_time' => 'required'
        ];
    }
}
