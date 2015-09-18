<?php

namespace App\Listeners;

use App\Events\DeleteUnpublishedNotification;
use App\Models\Item;
use App\Notification;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class DeleteListener
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
     * @param  DeleteUnpublishedNotification  $event
     * @return void
     */
    public function handle(DeleteUnpublishedNotification $event)
    {
        Notification::where('barcode', $event->barcode)->delete();
        var_dump('deleted');
    }
}
