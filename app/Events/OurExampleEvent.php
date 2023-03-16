<?php

namespace App\Events;

use App\Events\OurExampleEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class OurExampleEvent
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct($theEvent)
    {
       $this->username = $theEvent['username'];
       $this->action = $theEvent['action'];
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\OurExampleEvent  $event
     * @return void
     */
    public function handle(OurExampleEvent $event)
    {
        //
    }
}
