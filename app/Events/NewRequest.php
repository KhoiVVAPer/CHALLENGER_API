<?php

namespace App\Events;
use App\Notification;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;

class NewRequest implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $notifications;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Notification $notifications)
    {
        $this->notifications = $notifications;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        if($this->notifications->notification_type_id != 3){
            return new Channel('user.'.$this->notifications->user_id.'.notifications');
        }else if($this->notifications->notification_type_id == 3){
            return new Channel('team.'.$this->notifications->user_id.'.notifications');
        }
    }
}
