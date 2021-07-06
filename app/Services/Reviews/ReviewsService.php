<?php

namespace App\Services\Reviews;

use App\DTO\Reviews\ReviewsCreateDto;
use App\Entity\Review\Review;
use App\Filters\ReviewsFilter;
use Carbon\Carbon;
use App\Services\Translate\LingvanexTranslator;

class ReviewsService
{
    /**
     * @param array $data
     * @param ReviewsCreateDto $dto
     * @return Review
     * @throws \Throwable
     */
    public function store(ReviewsCreateDto $dto): Review
    {
        $girl = $dto->getGirl();
        $review = new Review();

        // проставляем переводы
        $translations_array = [];
        foreach ($dto->getReview() as $translation)
            $translations_array['review:' . $translation->getLocale()] = $translation->getValue();

        foreach ($translations_array as $key => $translation) {
            if (trim($translation) == "") {
                $translateFrom = 'en';
                $currentLang = 'ru';
                if ($key == 'review:en') {
                    $translateFrom = 'ru';
                    $currentLang = 'en';
                }
                try {
                    $tr = app(LingvanexTranslator::class);
                    $val = $tr
                        ->setLanguageFrom($translateFrom)
                        ->setLanguageTo($currentLang)
                        ->setText($translations_array['review:' . $translateFrom])
                        ->translate()->result;
                    $translations_array[$key] = $val;
                } catch(\Exception $e) {
                    \Log::error($e->getMessage());
                }
            }
        }

        $review->fill($translations_array);

        $translations_array = [];
        /*foreach ($dto->getMeetingCity() as $translation)
            $translations_array['meeting_city:' . $translation->getLocale()] = $translation->getValue();
        */

        foreach ($translations_array as $key => $translation) {
            if (trim($translation) == "") {
                $translateFrom = 'en';
                $currentLang = 'ru';
                if ($key == 'meeting_city:en') {
                    $translateFrom = 'ru';
                    $currentLang = 'en';
                }
                try {
                    $tr = app(LingvanexTranslator::class);

                    $val = $tr
                        ->setLanguageFrom($translateFrom)
                        ->setLanguageTo($currentLang)
                        ->setText($translations_array['meeting_city:' . $translateFrom])
                        ->translate()->result;
                    $translations_array[$key] = $val;
                } catch(\Exception $e) {
                    \Log::error($e->getMessage());
                }
            }
        }

        $review->fill($translations_array);

        $review->nickname = $dto->getNickname();
        $review->email = $dto->getEmail();
        //$review->meeting_date = Carbon::create($dto->getMeetingDate())->toDateString();
        //$review->duration = $dto->getDuration();
        //$review->duration_type = $dto->getDurationType();
        //$review->price = $dto->getPrice();
        //$review->country()->associate($dto->getCountry());
        //$review->currency()->associate($dto->getCurrency());

        $girl->reviews()->save($review);

        return $review;
    }

    public function paginate(int $count, array $params = [])
    {
        $filter = new ReviewsFilter($params);
        $query = Review::filter($filter);

        if(array_key_exists('sort', $params)) {
            $order = $params['sortOrder'] ?? 'desc';

            if(in_array($params['sort'], [
                'id',
                'created_at',
            ])) {
                $query->orderBy($params['sort'], $order);
            }
        }

        return $query
            ->orderBy('created_at', 'desc')
            ->paginate($count);
    }

    /**
     * @param Review $review
     * @param ReviewsCreateDto $dto
     * @return bool
     * @throws \Throwable
     */
    public function update(Review $review, ReviewsCreateDto $dto)
    {
        if ($dto->getReview())
            $review->review = $dto->getReview();
        if ( $dto->getNickname())
            $review->nickname = $dto->getNickname();
        if ($dto->getEmail())
            $review->email = $dto->getEmail();
        if ($dto->getMeetingDate())
            $review->meeting_date = Carbon::create($dto->getMeetingDate())->toDateString();
        if ($dto->getDuration())
            $review->duration = $dto->getDuration();
        if ($dto->getDurationType())
            $review->duration_type = $dto->getDurationType();
        if ($dto->getMeetingCity())
            $review->meeting_city = $dto->getMeetingCity();
        if ($dto->getPrice())
            $review->price = $dto->getPrice();
        if ($dto->getCountry())
            $review->country()->associate($dto->getCountry());
        if ($dto->getCurrency())
            $review->currency()->associate($dto->getCurrency());
        $review->published = $dto->getPublished();

        return $review->saveOrFail();
    }

}
