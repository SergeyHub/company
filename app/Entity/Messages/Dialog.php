<?php

namespace App\Entity\Messages;

use App\Entity\User\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Dialog extends Model
{

    use SoftDeletes;

    protected $fillable = ['user_first', 'user_second'];

    public function userFirst()
    {
        return $this->belongsTo(User::class, 'user_first');
    }

    public function userSecond()
    {
        return $this->belongsTo(User::class, 'user_second');
    }

    public function lastMessage()
    {
        return $this->belongsTo(Message::class, 'last_message_id');
    }

}
