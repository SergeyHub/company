<?php

namespace App\Console\Commands;

use App\Entity\Messages\Message;
use App\Notifications\UnreadMessage;
use Illuminate\Console\Command;

class SendUnreadMessageNotifications extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'messages:unread-noty';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Notify users about unread messages';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // выбираем непрочитанные сообщения за последние 20 минут
        $messages = Message::where('read', 0)
            ->where('notification_sended', 0)
            ->where('created_at', '<=', now()->subMinutes(20))
            ->get();

        foreach ($messages as $message) {
            $user_to = $message->userTo;
            if(!$user_to)
                continue;

            // отправляем оповещение
            if ($user_to->canReceiveNotifications())
                $user_to->notify(new UnreadMessage($message));

            // проставляем у сообщения метку об отправке оповещения
            $message->notification_sended = 1;
            $message->save();
        }
    }
}
