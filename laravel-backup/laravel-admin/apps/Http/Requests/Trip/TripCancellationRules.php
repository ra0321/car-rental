<?php

namespace App\Http\Requests\Trip;

use App\Exceptions\CustomException;
use App\Rules\RealBool;
use App\Models\Traits\Mutators;
use App\TripBill;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class TripCancellationRules
 * @package App\Http\Requests\Trip
 */
class TripCancellationRules extends FormRequest
{
    use Mutators;

    /**
     * @return bool
     * @throws CustomException
     */
    public function authorize()
    {
        $trip = $this->route('trip');
        $trip_bill = TripBill::where('trip_id', $trip->id)->get()->sortByDesc('created_at')->first();
        if($trip_bill->trip_bill_status == 'on hold'){
            throw new CustomException(THIS_TRANSACTION_IS_ON_HOLD_PLEASE_WAIT);
        }
        $user = $this->user();
        if($user->id === $trip->owner_id){
            if($trip->status === 'started'){
                throw new CustomException(OWNER_CAN_NOT_CANCEL_TRIP_AFTER_TRIP_STARTED);
            }
        }
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
        $promotions = isset($data['promotions']) ? $this->changeToBool($data['promotions']) : null;
        $unavailable = isset($data['unavailable']) ? $this->changeToBool($data['unavailable']) : null;
        $repair = isset($data['repair']) ? $this->changeToBool($data['repair']) : null;
        $guest_cancel = isset($data['guest_cancel']) ? $this->changeToBool($data['guest_cancel']) : null;
        $uncomfortable = isset($data['uncomfortable']) ? $this->changeToBool($data['uncomfortable']) : null;
        $other = isset($data['other']) ? $this->changeToBool($data['other']) : null;
// TODO SREDITI MALO KOD
        switch($data){
            case($promotions === true):
                if($unavailable || $repair || $guest_cancel || $uncomfortable || $other){
                    throw new CustomException(YOU_MAY_CHOOSE_ONLY_ONE_OPTION);
                }
                break;
            case($unavailable === true):
                if($promotions || $repair || $guest_cancel || $uncomfortable || $other){
                    throw new CustomException(YOU_MAY_CHOOSE_ONLY_ONE_OPTION);
                }
                break;
            case($repair === true):
                if($promotions || $unavailable || $guest_cancel || $uncomfortable || $other){
                    throw new CustomException(YOU_MAY_CHOOSE_ONLY_ONE_OPTION);
                }
                break;
            case($guest_cancel === true):
                if($promotions || $unavailable || $repair || $uncomfortable || $other){
                    throw new CustomException(YOU_MAY_CHOOSE_ONLY_ONE_OPTION);
                }
                break;
            case($uncomfortable === true):
                if($promotions || $unavailable || $guest_cancel || $repair || $other){
                    throw new CustomException(YOU_MAY_CHOOSE_ONLY_ONE_OPTION);
                }
                break;
            case($other === true):
                if($promotions || $unavailable || $repair){
                    throw new CustomException(YOU_MAY_CHOOSE_ONLY_ONE_OPTION);
                }
                break;
            default:
                throw new CustomException(YOU_MAY_CHOOSE_ONLY_ONE_OPTION);
        }
        return [
            'promotions' => [new RealBool(PROMOTIONS)],
            'unavailable' => [new RealBool(UNAVAILABLE)],
            'repair' => [new RealBool(REPAIR)],
            'guest_cancel' => [new RealBool(GUEST_CANCEL)],
            'uncomfortable' => [new RealBool(UNCOMFORTABLE)],
            'other' => [new RealBool(OTHER_REASON)],
            'reason' => 'required_if:other,true|nullable'
        ];
    }
}
