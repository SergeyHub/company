<?php

namespace App\Services\Messages;

use App\Entity\Messages\Dialog;
use App\Entity\User\User;
use Illuminate\Support\Facades\Cache;

class DialogService
{

    /**
     * Create or find exists dialog between users
     * @param int $user_first
     * @param int $user_second
     * @return Dialog
     */
    public function createDialog(int $user_first, int $user_second): Dialog
    {
        $user_first_id = min([$user_first, $user_second]);
        $user_second_id = max([$user_first, $user_second]);

        $dialog = Cache::rememberForever('dialog_'.$user_first_id.'_'.$user_second_id,
            function () use ($user_first_id, $user_second_id) {
               return Dialog::firstOrCreate([
                   'user_first' => $user_first_id,
                   'user_second' => $user_second_id,
               ]);
            });

        return $dialog;
    }

    /**
     * Get last user dialogs
     * @param User $user
     * @return mixed
     */
    public function getUserDialogs(User $user)
    {
        return Dialog::with('lastMessage', 'userFirst', 'userSecond')
            ->where('user_first', $user->id)
            ->orWhere('user_second', $user->id)
            ->orderBy('last_message_time', 'desc')
            ->get();
    }

}
