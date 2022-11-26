<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Events\LanzaPregunta;

class BroadcastUserLogin
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
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
		//\Log::debug("Se lanzó la pregunta {$event->user->name}");
        //broadcast(new LanzaPregunta("Se lanzó la pregunta {$event->user->name}"));
    }
}
