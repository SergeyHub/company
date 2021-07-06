<?php

/*
 * Заказ клиента по покупке телефона девушки
 */

namespace App\Entity\Orders;

use App\Entity\Bill\Bill;
use App\Entity\Girl\Girl;
use App\Entity\Orders\Interfaces\Order;
use App\Entity\User\User;
use App\Entity\User\UserGirlAccess;
use Illuminate\Database\Eloquent\Model;

class OrderGirlPhone extends Model implements Order
{

    protected $fillable = ['user_id', 'girl_id'];

    public function girl()
    {
        return $this->belongsTo(Girl::class, 'girl_id');
    }

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
        // добавляем девушку в список доступных для клиента
        $this->user->girls()->firstOrCreate(['girl_id' => $this->girl_id]);
    }

}
