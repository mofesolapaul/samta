<?php

namespace App\Listeners;

use App\Events\TransactionOccurred;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class LogTransaction
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
     * @param  TransactionOccurred  $event
     * @return void
     */
    public function handle(TransactionOccurred $event)
    {
        $event->transaction->save();
    }
}
