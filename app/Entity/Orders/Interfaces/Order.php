<?php

namespace App\Entity\Orders\Interfaces;

interface Order
{

    /*
     * Выдача материалов/доступов заказа
     */
    public function afterPay(): void;

}
