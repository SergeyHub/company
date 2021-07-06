<?php

namespace App\Events;

use App\Entity\Messages\Message;
use App\Http\Resources\Messages\DialogResource;
use App\Http\Resources\Messages\MessageResource;
use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class PrivateMessage implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message, $dialog;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Message $message, $first_message=false)
    {
        $this->message = new MessageResource($message);
        // если это первое сообщение в диалоге
        if($first_message) {
            $this->dialog = new DialogResource($message->dialog);
        }
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return [
            new PrivateChannel('App.User.'.$this->message->user_to_id),
            new PrivateChannel('App.User.'.$this->message->user_from_id),
        ];
    }

    public function broadcastAs()
    {
        return 'PrivateMessage';
    }

}
