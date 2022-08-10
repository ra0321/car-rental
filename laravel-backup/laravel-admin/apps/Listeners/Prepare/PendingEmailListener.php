<?php

namespace App\Listeners\Prepare;

use App\Events\Prepare\PendingEmailEvent;
use App\PendingEmail;
use Exception;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Log;

class PendingEmailListener
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
     * @param  PendingEmailEvent  $event
     * @return void
     */
    public function handle(PendingEmailEvent $event)
    {
        $pending = new PendingEmail();
        $pending['event_name'] = $event->event_name;
        $pending['user_id'] = $event->user_id;
        $pending['trip_id'] = $event->trip_id;
        try{
            $pending->save();
        }catch(Exception $e){
            Log::alert('There are errors preparing the email', ['exception' => $e]);
        }
    }
}
