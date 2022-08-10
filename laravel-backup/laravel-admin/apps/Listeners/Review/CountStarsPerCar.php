<?php

namespace App\Listeners\Review;

use App\Car;
use App\Events\Review\LeaveReviewEvent;
use App\User;

class CountStarsPerCar
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
        $car = Car::findOrFail($event->trip->car_id);
        $owner = User::findOrFail($car->user_id);
        $stars = $event->reviewMessage->stars;

        $car['count_reviews'] += 1;
        $car['count_rates'] += $stars;
        $car['count_stars'] = round($car['count_rates'] / $car['count_reviews'], 2);
        $owner['reviewed_as_owner'] += 1;
        $owner['count_stars_as_owner'] += $stars;
        $owner['stars_as_owner'] = round($owner['count_stars_as_owner'] / $owner['reviewed_as_owner'], 2);
        if($owner['stars_as_renter']){
            $owner['user_stars'] = round(($owner['stars_as_renter'] + $owner['stars_as_owner']) / 2, 2);
        }else{
            $owner['user_stars'] = $owner['stars_as_owner'];
        }
        $car->save();
        $owner->save();
    }
}
