<?php

namespace App\Listeners;

use App\Events\SupportMessageCreated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SupportMessageListener
{
    /**
     * Handle the event.
     *
     * @param  SupportMessageCreated  $event
     * @return void
     */
    public function handle(SupportMessageCreated $event)
    {
        $message = $event->message;
        if (!$message)
            return;

        $dialog = $message->dialog;
        if(!$dialog)
            return;

        // обновляем дату последнего сообщения в диалоге
        $dialog->last_message_time = $message->created_at;
        $dialog->lastMessage()->associate($message);
        $dialog->saveOrFail();
    }
}
