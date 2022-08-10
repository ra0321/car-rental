<?php

namespace App\Http\Requests\Car;

use App\Exceptions\CustomException;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class CarUpdateCustomPriceRules
 * @package App\Http\Requests\Car
 */
class CarUpdateCustomPriceRules extends FormRequest
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
        $request = $this->request->all();
        if(isset($request['price_from_date']) && isset($request['price_until_date'])){
            $now_date = Carbon::now()->format('Y-m-d');
            $now = Carbon::parse($now_date);
            $startDate = Carbon::parse($request['price_from_date']);
            $endDate = Carbon::parse($request['price_until_date']);

            if($startDate->gte($endDate) || $startDate->lt($now)){
                throw new CustomException(UNALLOWED_DATES);
            }
        }

        return [
            'custom_price' => 'required|numeric|max:10000|min:10',
            'price_from_date' => 'required',
            'price_until_date' => 'required'
        ];
    }
}
