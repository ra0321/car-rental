<?php

namespace App\Listeners\Car;

use App\BookInstantly;
use App\Events\Car\ListCar;

class BookInstantlyEvent
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Handle the event.
     *
     * @param  ListCar  $event
     * @return void
     */
    public function handle(ListCar $event)
    {
        $bookInstantly = new BookInstantly();
        $bookInstantly->car_id = $event->car->id;
        $bookInstantly->save();
    }
}
