<?php

namespace App\Listeners\Review;

use App\User;
use App\Events\Review\LeaveReviewEvent;

class CountReviewsPerUser
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
     * Handle the event.
     *
     * @param  LeaveReviewEvent  $event
     * @return void
     */
    public function handle($event)
    {
        if($event->user->id === $event->review->owner_id){
            $user = User::whereId($event->review->renter_id)->firstOrFail();
            $user['reviewed'] += 1;
            $user['count_stars'] += $event->reviewMessage->stars;
            $user['stars_as_renter'] = round($user['count_stars'] / $user['reviewed']);
            if($user['stars_as_owner']){
                $user['user_stars'] = round(($user['stars_as_renter'] + $user['stars_as_owner']) / 2, 2);
            }else{
                $user['user_stars'] = $user['stars_as_renter'];
            }
            $user->save();
        }
    }
}
