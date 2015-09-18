<?php

namespace App\Events;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class DeleteUnpublishedNotification extends Event
{
    use SerializesModels;

    public  $barcode;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($barcode)
    {
        //
        $this->barcode = $barcode;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return [];
    }
}
