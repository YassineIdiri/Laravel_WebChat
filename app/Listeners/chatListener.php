<?php

namespace App\Listeners;

use App\Events\chatNotif;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class chatListener
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
    public function handle(chatNotif $event): void
    {
        dd($event);
    }
}
