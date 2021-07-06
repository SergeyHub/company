<?php

namespace App\Entity\Orders;

use App\Entity\Bill\Bill;
use App\Entity\User\User;
use App\Entity\Girl\Girl;
use Illuminate\Database\Eloquent\Model;

class OrderGirlVip extends Model
{
    protected $fillable = ['user_id', 'girl_id', 'tariff_id', 'cost_type'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function bill()
    {
        return $this->morphOne(Bill::class, 'order');
    }

    public function girl()
    {
        return $this->belongsTo(Girl::class, 'girl_id');
    }

    public function afterPay(): void
    {
        if(!$this->girl)
            return;

        $days = $this->cost_type == 'month' ? 30 : 365;
        $this->girl->setVip();
        $this->girl->extendVipDays($days);

        $this->girl->save();
    }

}
