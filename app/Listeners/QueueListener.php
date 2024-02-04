<?php

namespace App\Listeners;

use App\Events\QueueEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class QueueListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(QueueEvent $event): void
    {
        broadcast(new QueueEvent($event->number));
    }
}
