<?php

namespace App\Services\Offers;

use App\DTO\Offers\OfferDto;
use App\Entity\Offer\Offer;
use App\Entity\User\User;
use App\Exceptions\ValidationException;
use App\Filters\OffersFilter;
use Illuminate\Support\Facades\Cache;

class OfferService
{

    public function find($id): Offer
    {
        return Offer::findOrFail($id);
    }

    public function findPublishedOffer($id): Offer
    {
        return Cache::rememberForever('offer_published_'.$id, function () use ($id) {
            return Offer::published()->findOrFail($id);
        });
    }

    /**
     * @param OfferDto $dto
     * @return Offer
     * @throws \Throwable
     */
    public function create(OfferDto $dto): Offer
    {
        if($dto->getCity()->country_id != $dto->getCountry()->id)
            throw new ValidationException('The city does not belong to the country');

        $offer = new Offer;

        // проставляем переводы
        $translations_array = [];
        foreach ($dto->getContent() as $translation)
            $translations_array['content:'.$translation->getLocale()] = $translation->getValue();
        foreach ($dto->getName() as $translation)
            $translations_array['name:'.$translation->getLocale()] = $translation->getValue();

        // выставляем статус проверки
        $offer->status = Offer::STATUS_INSPECTION;
        $offer->cost = $dto->getCost();
        $offer->fill($translations_array);

        $offer->client()->associate($dto->getClient());
        $offer->country()->associate($dto->getCountry());
        $offer->city()->associate($dto->getCity());
        $offer->saveOrFail();
        return $offer;
    }

    /**
     * @param Offer $offer
     * @param BlogDto $dto
     * @return bool
     * @throws \Throwable
     */
    public function update(Offer $offer, OfferDto $dto): bool
    {
        if($dto->getCity()->country_id != $dto->getCountry()->id)
            throw new ValidationException('The city does not belong to the country');

        // проставляем переводы
        $translations_array = [];
        foreach ($dto->getContent() as $translation)
            $translations_array['content:'.$translation->getLocale()] = $translation->getValue();
        foreach ($dto->getName() as $translation)
            $translations_array['name:'.$translation->getLocale()] = $translation->getValue();

        $offer->cost = $dto->getCost();

        if ($dto->getStatus())
            $offer->status = $dto->getStatus();

        $offer->fill($translations_array);

        $offer->country()->associate($dto->getCountry());
        $offer->city()->associate($dto->getCity());

        // обнуляем кэш
        Cache::forget('offer_published_'.$offer->id);

        return $offer->saveOrFail();
    }

    /**
     * @param Offer $offer
     * @return bool
     * @throws \Exception
     */
    public function deleteOffer(Offer $offer): bool
    {
        return $offer->delete();
    }

    /**
     * @param array $params
     * @return mixed
     */
    public function paginatePublishedOffers($params=[])
    {
        $query = Offer::with('translations')
            ->where('status', Offer::STATUS_PUBLISHED);
        if(isset($params['country'])) {
            $query = $query->where('country_id', $params['country']);
        }
        if(isset($params['city'])) {
            $query = $query->where('city_id', $params['city']);
        }
        return $query->orderBy('created_at', 'desc')
            ->paginate(20);
    }

    /**
     * @param User $user
     * @return mixed
     */
    public function paginateUserOffers(User $user)
    {
        return Offer::with('translations')
            ->join('clients', 'clients.id', 'offers.client_id')
            ->where('clients.user_id', $user->id)
            ->orderBy('offers.created_at', 'desc')
            ->selectRaw('offers.*')
            ->paginate(20);
    }

    public function paginate(int $count, array $params = [])
    {
        $filter = new OffersFilter($params);
        return Offer::with('translations')
            ->filter($filter)
            ->orderBy('created_at', 'desc')
            ->paginate($count);
    }

}
