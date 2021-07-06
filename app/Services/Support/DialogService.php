<?php

namespace App\Services\Support;

use App\Entity\Support\SupportDialog;

class DialogService
{

    /**
     * Create or find existing dialog
     * @param int $user_id
     * @return SupportDialog
     */
    public function createDialog(int $user_id): SupportDialog
    {
        $dialog = SupportDialog::firstOrCreate([
            'user_id' => $user_id,
        ]);
        return $dialog;
    }

    public function paginateDialogs(int $count=20)
    {
        return SupportDialog::with('user', 'lastMessage')
            ->orderBy('last_message_date', 'desc')
            ->paginate($count);
    }

}
