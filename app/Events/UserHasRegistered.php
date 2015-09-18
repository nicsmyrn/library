<?php

namespace App\Events;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class UserHasRegistered extends Event implements ShouldBroadcast
{
    use SerializesModels;

    public $users;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Collection $user)
    {
        //
        $this->users = $user;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return ['test'];
    }
}
