<?php

/*
 * Заказ клиента по публикации предложения
 */

namespace App\Entity\Orders;

use App\Entity\Bill\Bill;
use App\Entity\Offer\Offer;
use App\Entity\Orders\Interfaces\Order;
use App\Entity\User\User;
use Illuminate\Database\Eloquent\Model;

class OrderOfferPublication extends Model implements Order
{

    protected $fillable = ['user_id', 'offer_id'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function bill()
    {
        return $this->morphOne(Bill::class, 'order');
    }

    public function offer()
    {
        return $this->morphOne(Offer::class, 'offer_id');
    }

    public function afterPay(): void
    {
        if(!$this->offer)
            return;
        // выставляем статус предложение на "На проверке"
        $this->offer->setInspection();
    }

}
