<?php

namespace App\Services\Bills;

use App\Entity\Bill\Bill;
use App\Entity\Girl\Girl;
use App\Entity\Offer\Offer;
use App\Entity\Orders\OrderBuyOfferPhone;
use App\Entity\Orders\OrderGirlPhone;
use App\Entity\Orders\OrderGirlPublication;
use App\Entity\Orders\OrderGirlVip;
use App\Entity\Orders\OrderOfferPublication;
use App\Entity\Tariffs\PublicationTariff;
use App\Entity\Tariffs\VipTariff;
use App\Entity\User\User;
use App\Filters\BillsFilter;
use App\Notifications\SuccessPaymentBill;
use App\Services\Geo\CountryService;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class BillService
{

    /** @var CountryService */
    private $countryService;

    public function __construct()
    {
        $this->countryService = app(CountryService::class);
    }

    /**
     * @param string $id
     * @return Bill|null
     */
    public function findActiveBill(string $id): ?Bill
    {
        return Bill::active()->find($id);
    }

    /**
     * Оплатить счет
     * @param Bill $bill
     */
    public function setPaid(Bill $bill): void
    {
        if(!$bill->setPaid())
            return;

        // выдаем доступ к заказу
        if($bill->order)
            $bill->order->afterPay();

        // высылаем оповещение об успешной оплате счета
        if($bill->user)
            $bill->user->notify(new SuccessPaymentBill($bill));
    }

    /**
     * @param User $user
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function paginateForUser(User $user): LengthAwarePaginator
    {
        return Bill::where('user_id', $user->id)
            ->latest()
            ->paginate(20);
    }

    public function paginate(int $count, array $params = [])
    {
        $filter = new BillsFilter($params);
        return Bill::filter($filter)->paginate($count);
    }

    /**
     * Создание счета публикации девушки
     * @param User $user
     * @param Girl $girl
     * @param PublicationTariff $tariff
     * @return Bill
     * @throws \Throwable
     */
    public function createGirlPublicationBill(User $user, Girl $girl, $tariff_id=null): Bill
    {
        if($tariff_id) {
            $tariff = PublicationTariff::find($tariff_id);
        }

        if(!$tariff_id || !$tariff) {
            $tariff = PublicationTariff::query()->first();
        }

        if(!$tariff)
            throw new \InvalidArgumentException('Error tariff');

        $order = OrderGirlPublication::firstOrCreate([
            'user_id' => $user->id,
            'girl_id' => $girl->id,
            'tariff_id' => $tariff->id
        ]);

        if($order->bill)
            return $order->bill;

        $bill = new Bill;
//        $bill->amount = $this->countryService->getGirlPublicationCostInCountry($girl->country);
        $bill->amount = $tariff->cost;
        $bill->order()->associate($order);
        $bill->user()->associate($user);
        $bill->status = Bill::STATUS_ACTIVE;
        $bill->saveOrFail();

        return $bill;
    }

    /**
     * Создание счета публикации девушки
     * @param User $user
     * @param Girl $girl
     * @param PublicationTariff $tariff
     * @return Bill
     * @throws \Throwable
     */
    public function createGirlVipBill(User $user, Girl $girl, $tariff_id, $costType): Bill
    {
        if($tariff_id) {
            $tariff = VipTariff::find($tariff_id);
        }

        if(!$tariff_id || !$tariff) {
            $tariff = VipTariff::query()->first();
        }

        if(!$tariff)
            throw new \InvalidArgumentException('Error tariff');

        $order = OrderGirlVip::firstOrCreate([
            'user_id' => $user->id,
            'girl_id' => $girl->id,
            'tariff_id' => $tariff->id,
            'cost_type' => $costType,
            'cost' => $tariff->{$costType.'_cost'}
        ]);

        if($order->bill)
            return $order->bill;

        $bill = new Bill;
//        $bill->amount = $this->countryService->getGirlPublicationCostInCountry($girl->country);
        $bill->amount = $tariff->{$costType . '_cost'};
        $bill->order()->associate($order);
        $bill->user()->associate($user);
        $bill->status = Bill::STATUS_ACTIVE;
        $bill->saveOrFail();

        return $bill;
    }

    /**
     * Создание счета покупки телефона девушки
     * @param User $user
     * @param Girl $girl
     * @return Bill
     * @throws \Throwable
     */
    public function createGirlPhoneBill(User $user, Girl $girl): Bill
    {
        $order = OrderGirlPhone::firstOrCreate([
            'user_id' => $user->id,
            'girl_id' => $girl->id
        ]);

        if($order->bill)
            return $order->bill;

        $bill = new Bill;
        $bill->amount = $this->countryService->getGirlPhoneCostInCountry($girl->country);
        $bill->order()->associate($order);
        $bill->user()->associate($user);
        $bill->status = Bill::STATUS_ACTIVE;
        $bill->saveOrFail();

        return $bill;
    }


    /**
     * Создание счета к публикации предложения
     * @param User $user
     * @param Offer $offer
     * @return Bill
     * @throws \Throwable
     */
    public function createOfferPublicationBill(User $user, Offer $offer): Bill
    {
        $order = OrderOfferPublication::firstOrCreate([
            'user_id' => $user->id,
            'offer_id' => $offer->id
        ]);

        if($order->bill)
            return $order->bill;

        $bill = new Bill;
        $bill->amount = config('costs.offer_publication_cost', 200);
        $bill->order()->associate($order);
        $bill->user()->associate($user);
        $bill->status = Bill::STATUS_ACTIVE;
        $bill->saveOrFail();

        return $bill;
    }

    /**
     * Создание счета на покупку доступа к офферу
     * @param User $user
     * @param Offer $offer
     * @return Bill
     * @throws \Throwable
     */
    public function createBuyOfferPhoneBill(User $user, Offer $offer): Bill
    {
        $order = OrderBuyOfferPhone::firstOrCreate([
            'user_id' => $user->id,
            'offer_id' => $offer->id
        ]);

        if($order->bill)
            return $order->bill;

        $bill = new Bill;
        $bill->amount = config('costs.offer_buy_cost', 200);
        $bill->order()->associate($order);
        $bill->user()->associate($user);
        $bill->status = Bill::STATUS_ACTIVE;
        $bill->saveOrFail();

        return $bill;
    }

}
