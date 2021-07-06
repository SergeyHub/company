<?php

namespace App\Services\Clients;

use App\DTO\Clients\ClientDto;
use App\Entity\Clients\Client;
use App\Filters\ClientsFilter;

class ClientService
{

    /**
     * @param Client $client
     * @param ClientDto $dto
     * @return bool
     * @throws \Throwable
     */
    public function update(Client $client, ClientDto $dto): bool
    {
        $client->name = $dto->getName();
        $client->phone = $dto->getPhone();
        $client->age = $dto->getAge();
        $client->country()->associate($dto->getCountry());
        $client->city()->associate($dto->getCity());
        $client->nationality()->associate($dto->getNationality());

        // проставляем переводы
        $translations_array = [];
        foreach ($dto->getAbout() as $translation)
            $translations_array['about:'.$translation->getLocale()] = $translation->getValue();
        $client->fill($translations_array);

        return $client->saveOrFail();
    }

    public function paginate(int $count, array $params = [])
    {
        $filter = new ClientsFilter($params);
        return Client::filter($filter)
            ->orderBy('created_at', 'desc')
            ->paginate($count);
    }

}
