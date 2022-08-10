<?php

namespace App\Http\Requests\Review;

use App\Exceptions\CustomException;
use App\Review;
use App\ReviewMessage;
use App\Trip;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpKernel\Exception\HttpException;

/**
 * Class CreateReviewRules
 * @package App\Http\Requests\Review
 */
class CreateReviewRules extends FormRequest
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
        $review_id = $this->request->get('review_id');
        $user = $this->user();
        $review = Review::whereId($review_id)->firstOrFail();
        $trip = Trip::whereId($review['trip_id'])->firstOrFail();
        $reviewed = ReviewMessage::where('review_id', $review['id'])->where('user_id', $user->id)->first();
        if($reviewed){
            throw new CustomException(YOU_ALREADY_ENTER_REVIEW_FOR_THIS_TRIP);
        }
        if($trip->status !== 'finished'){
            throw new CustomException(THIS_TRIP_IS_NOT_YET_FINISHED);
        }
        if($trip->status === 'canceled'){
            throw new CustomException(YOU_CAN_NOT_REVIEW_CANCELED_TRIP);
        }
        return [
            'review_message' => 'required',
            'stars' => ['required', Rule::in([1, 2, 3, 4, 5])],
        ];
    }
}
