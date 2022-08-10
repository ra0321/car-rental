<?php

namespace App\Http\Requests\Car;

use App\Exceptions\CustomException;
use App\Models\Traits\Mutators;
use App\Rules\RealBool;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class ReportListingRules
 * @package App\Http\Requests\Car
 */
class ReportListingRules extends FormRequest
{
    use Mutators;
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
        if(count($data) < 1){
            throw new CustomException(YOU_MUST_CHOOSE_ONE_OPTION);
        }
        $inappropriate = isset($data['inappropriate']) ? $this->changeToBool($data['inappropriate']) : null;
        $misleading = isset($data['misleading']) ? $this->changeToBool($data['misleading']) : null;
        $spam = isset($data['spam']) ? $this->changeToBool($data['spam']) : null;
        $other = isset($data['other']) ? $this->changeToBool($data['other']) : null;

        switch($data){
            case($inappropriate === true):
                if($misleading || $spam || $other){
                    throw new CustomException(YOU_MAY_CHOOSE_ONLY_ONE_OPTION);
                }
                break;
            case($misleading === true):
                if($inappropriate || $spam || $other){
                    throw new CustomException(YOU_MAY_CHOOSE_ONLY_ONE_OPTION);
                }
                break;
            case($spam === true):
                if($inappropriate || $misleading || $other){
                    throw new CustomException(YOU_MAY_CHOOSE_ONLY_ONE_OPTION);
                }
                break;
            case($other === true):
                if($inappropriate || $misleading || $spam){
                    throw new CustomException(YOU_MAY_CHOOSE_ONLY_ONE_OPTION);
                }
                break;
            default:
                throw new CustomException(YOU_MAY_CHOOSE_ONLY_ONE_OPTION);
        }
        return [
            'inappropriate' => [new RealBool(INAPPROPRIATE)],
            'misleading' => [new RealBool(MISLEADING)],
            'spam' => [new RealBool(SPAM)],
            'other' => [new RealBool(OTHER)],
            'reason' => 'required_if:other,true|nullable'
        ];
    }
}
