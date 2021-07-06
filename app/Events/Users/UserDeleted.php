<?php

namespace App\Events\Users;

use App\Entity\User\User;
use Illuminate\Queue\SerializesModels;

class UserDeleted
{
    use SerializesModels;

    public $user;

    /**
     * UserDeleted constructor.
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

}
