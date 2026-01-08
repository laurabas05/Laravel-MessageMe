<?php

namespace App\Events;

use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

use App\Models\Message;

class MessageSent implements ShouldBroadcast
{
    public Message $message;
    
    /**
     * Create a new event instance.
     */
    public function __construct(Message $message)
    {
        $this->message = $message->load('user');

        if ($this->message->user->profile_photo) {
            $this->message->user->profile_photo_url =
                asset('storage/' . $this->message->user->profile_photo);
        } else {
            $this->message->user->profile_photo_url =
                asset('default-avatar.png');
        }
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): PrivateChannel
    {
        logger('EVENT channel', [
            'channel' => 'conversation.' . $this->message->conversation_id
        ]);

        return new PrivateChannel('conversation.' . $this->message->conversation_id);
    }

    public function broadcastAs() {
        return 'message.sent';
    }
}