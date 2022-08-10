<?php

namespace App\Listeners\Trip;

use App\Review;

/**
 * Class CreateReviewEvent
 * @package App\Listeners\Trip
 */
class CreateReviewEvent
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

	/**
	 * @param $event
	 *
	 * @throws \Exception
	 */
	public function handle($event)
    {
        $review = new Review();
        $review['trip_id'] = $event->data['trip']->id;
        $review['owner_id'] = $event->data['trip']->owner_id;
        $review['renter_id'] = $event->data['trip']->renter_id;

        try{
	        $review->save();
        }catch(\PDOException $exception){
	        $error_message = $exception->getMessage();
	        $error_code = (int)$exception->getCode();
	        //throw new \Exception($error_message, $error_code);
	        throw new \PDOException($error_message, $error_code);
        }
    }
}
