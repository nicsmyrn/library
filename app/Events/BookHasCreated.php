<?php

namespace App\Events;

use App\Events\Event;
use App\User;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Hash;

class BookHasCreated extends Event implements ShouldBroadcast
{
    use SerializesModels;

    public $text;
    public $time;
    public $url;
    public $userId;
    public $barcode;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($text, $time, $url, $user_id, $barcode)
    {
        //
        $this->text = $text;
        $this->time = $time;
        $this->url = $url;
        $this->userId = $user_id;
        $this->barcode = $barcode;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return ['notification-'.$this->userId];
    }
}
