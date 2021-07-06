<?php

namespace App\Entity\Support;

use App\Entity\User\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SupportDialog extends Model
{

    use SoftDeletes;

    protected $fillable = ['user_id'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function lastMessage()
    {
        return $this->belongsTo(SupportMessage::class, 'last_message_id');
    }

}
