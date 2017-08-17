<?php

namespace App\Listeners;

use App\Events\Affect;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class AffectListener
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
     * @param  Affect  $event
     * @return void
     */
    public function handle(Affect $event)
    {
        //
    }
}
