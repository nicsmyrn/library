<?php

namespace App\Listeners;

use App\Events\BookHasCreated;
use App\Notification;
use Carbon\Carbon;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class NotificationListener
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
     * @param  BookHasCreated  $event
     * @return void
     */
    public function handle(BookHasCreated $event)
    {
        //
        Notification::create([
            'user_id' => \Auth::id(),
            'text' => $event->text,
            'url' => $event->url,
            'created_on' => Carbon::now(),
            'unread' => $event->unread,
            'barcode' => $event->barcode
        ]);
    }
}
