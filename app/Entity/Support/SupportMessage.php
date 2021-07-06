<?php

namespace App\Entity\Support;

use App\Entity\User\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SupportMessage extends Model
{

    use SoftDeletes;

    public function dialog()
    {
        return $this->belongsTo(SupportDialog::class, 'dialog_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}
