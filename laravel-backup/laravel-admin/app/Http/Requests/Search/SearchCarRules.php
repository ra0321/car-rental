<?php

namespace App\Http\Requests\Search;

use App\Exceptions\CustomException;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class SearchCarRules
 * @package App\Http\Requests\Search
 */
class SearchCarRules extends FormRequest
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
	    $now = Carbon::now();
        return [
	        'start_date' => 'date|required|after:' . $now->format('Y-m-d H:i:s'),
            'end_date' => 'date|required|after:start_date',
	        'city' => 'required_without:airport',
	        'airport' => 'required_without:city',
        ];
    }
}
