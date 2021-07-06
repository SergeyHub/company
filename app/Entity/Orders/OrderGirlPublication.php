<?php

/*
 * Заказ девушки по оплате публикации анкеты
 */

namespace App\Entity\Orders;

use App\Entity\Bill\Bill;
use App\Entity\Girl\Girl;
use App\Entity\Orders\Interfaces\Order;
use App\Entity\Tariffs\PublicationTariff;
use App\Entity\User\User;
use Illuminate\Database\Eloquent\Model;

class OrderGirlPublication extends Model implements Order
{

    protected $fillable = ['user_id', 'girl_id', 'tariff_id'];

    public function girl()
    {
        return $this->belongsTo(Girl::class, 'girl_id');
    }

    public function tariff()
    {
        return $this->belongsTo(PublicationTariff::class, 'tariff_id');
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
        /** @var Girl $girl */
        $girl = $this->girl;

        if(!$girl)
            return;

        /** @var PublicationTariff $tariff */
        $tariff = $this->tariff;

        if(!$tariff)
            return;

        // увеличиваем оплаченное время публикации
        $girl->extendPublicationDays($this->tariff->days);

        // если девушка не проверена, то отправляем на проверку
        if(!$girl->isVerified())
            $girl->setWaitVerify();
    }

}
