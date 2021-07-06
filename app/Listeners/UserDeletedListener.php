<?php

namespace App\Listeners;

use App\Events\Users\UserDeleted;

class UserDeletedListener
{
    /**
     * @param UserDeleted $event
     */
    public function handle(UserDeleted $event)
    {
        // удаляем анкету модели
        if($event->user->girl)
            $event->user->girl->delete();

        // удаляем анкету клиента
        if($event->user->client)
            $event->user->client->delete();

        // удаляем анкету агентства
        if($event->user->agency)
            $event->user->agency->delete();
    }
}
