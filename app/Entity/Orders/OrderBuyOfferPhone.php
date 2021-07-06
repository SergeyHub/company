<?php

namespace App\Entity\Orders;

use App\Entity\Bill\Bill;
use App\Entity\Orders\Interfaces\Order;
use App\Entity\User\User;
use Illuminate\Database\Eloquent\Model;

class OrderBuyOfferPhone extends Model implements Order
{

    protected $fillable = ['offer_id', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function bill()
    {
        return $this->morphOne(Bill::class, 'order');
    }

    public function afterPay(): void
    {
        if(!$this->user)
            return;
        // добавляем предложение в список доступных для модели
        $this->user->offers()->firstOrCreate(['offer_id' => $this->offer_id]);
    }

}
