<?php

namespace App\Services\Girl;

use App\DTO\Girls\GirlCreateDto;
use App\Entity\Documents\Document;
use App\Entity\Geo\Country\Country;
use App\Entity\Girl\Girl;
use App\Entity\ProfileSite\ProfileSite;
use App\Entity\Review\Review;
use App\Entity\User\User;
use App\Exceptions\ValidationException;
use App\Filters\GirlsFilter;
use App\Notifications\FailedPublish;
use App\Notifications\FailedVerification;
use App\Notifications\SuccessVerification;
use App\Services\Images\TextToImage;
use App\Services\Sms\SmsSender;
use App\Services\Support\MessageService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Spatie\MediaLibrary\Models\Media;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use App\Services\Translate\LingvanexTranslator;
use App\DTO\Girls\GirlRejectVerificationDto;

class GirlService
{

    /** @var ValidatorInterface */
    private $validator;

    /** @var SmsSender */
    private $smsSender;

    /** @var MessageService  */
    private $messageService;

    /** @var TextToImage */
    private $textToImage;

    public function __construct(SmsSender $smsSender, MessageService $messageService, TextToImage $textToImage)
    {
        $this->validator = Validation::createValidatorBuilder()
            ->addMethodMapping('loadValidatorMetadata')
            ->getValidator();
        $this->smsSender = $smsSender;
        $this->messageService = $messageService;
        $this->textToImage = $textToImage;
    }

    public function getTop50Girls($params = []) {
        return self::publishedGirlsDefault($params)
            ->limit(50)
            ->orderBy('views', 'desc')
            ->get();
    }

    /**
     * @param $id
     * @return Girl
     */
    public function find($id): Girl
    {
        return Girl::findOrFail($id);
    }

    /**
     * @param $id
     * @return Girl
     * @throws ModelNotFoundException
     */
    public function findPublishedGirl($id): Girl
    {
        $girl = Girl::with('nationality', 'orientation', 'body', 'bodyHair', 'ethnicity',  'avatar', 'languages', 'geographies', 'whatLikes', 'readyFors', 'reviews')
            ->where('status', Girl::STATUS_PUBLISHED)
            ->findOrFail($id);
        $girl->view();
        return $girl;
    }

    private function publishedGirlsDefault($params=[])
    {
        $query = Girl::where('status', Girl::STATUS_PUBLISHED);
        if(isset($params['country'])) {
            $query = $query->where('country_id', $params['country']);
        }

        if(isset($params['ready_for_travels']) && $params['ready_for_travels'] == 'true') {
            $params['ready_for_travels'] = 1;
        } else {
            unset($params['ready_for_travels']);
        }

        $filter = new GirlsFilter($params);
        $query =  Girl::filter($filter)->where('status', Girl::STATUS_PUBLISHED);

        if(auth('api')->user()) {
            $hidden = auth('api')->user()->hiddenGirls()->pluck('girls.id');
            $query->whereNotIn('id', $hidden);
        }

        return $query;
    }

    /**
     * @param array $params
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function paginatePornstarGirls($params=[])
    {
        return self::publishedGirlsDefault($params)
            ->where('pornstar', 1)
            ->orderBy('created_at', 'desc')
            ->paginate(21);
    }

    /**
     * @param array $params
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function paginateKeptWomans($params=[])
    {
        return self::publishedGirlsDefault($params)
            ->where('type', Girl::TYPE_KEPT_WOMANS)
            ->paginate(21);
    }

    /**
     * @param array $params
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function paginateVipGirls($params=[])
    {
        return self::publishedGirlsDefault($params)
            ->where('vip', 1)
            ->paginate(21);
    }
    /**
     * @param array $params
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function paginateTravelGirls($params=[])
    {
        $query = self::publishedGirlsDefault($params)
            ->where('type', Girl::TYPE_TRAVELS);

        if (isset($params['geography'])) {
            $query = $query->whereHas('geographies', function ($query) use ($params) {
                $query->where('geographies.id', $params['geography']);
            });
        }

        return $query->paginate(21);
    }

    /**
     * @param array $params
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function paginateDating($params=[])
    {
        return self::publishedGirlsDefault($params)
            ->where('type', Girl::TYPE_DATING)
            ->paginate(21);
    }

    /**
     * @param array $params
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function paginateShemales($params=[])
    {
        return self::publishedGirlsDefault($params)
            ->where('type', Girl::TYPE_SHEMALES)
            ->paginate(21);
    }

    /**
     * @param array $params
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function paginateTop50Girls($params=[])
    {
        return self::publishedGirlsDefault($params)
            ->limit(50)
            ->orderBy('views', 'desc')
            ->paginate(21);
    }

    /**
     * @param array $params
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function paginateVideoGirls($params=[])
    {
        return Media::where('collection_name', Girl::PUBLIC_VIDEOS)
            ->whereHasMorph('model', Girl::class, function ($query) {
                $query->where('status', Girl::STATUS_PUBLISHED);
            })->paginate(21);
    }

    /**
     * @param array $params
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function paginateReviewGirls($params=[])
    {
        $query = Review::where('published', true);

        if(isset($params['country'])) {
            $query = $query->whereHasMorph('model', Girl::class,  function ($query) use ($params) {
                $query->where('country_id', $params['country']);
            });
        }
        if(isset($params['city'])) {
            $query = $query->whereHasMorph('model', Girl::class, function ($query) use ($params) {
                $query->where('city_id', $params['city']);
            });
        }
        return $query->paginate(21);
    }

    /**
     * @return Girl
     */
    public function favourites()
    {
        return Girl::whereHas('favourites', function ($q) {
            $q->where('user_id', Auth::user()->id);
        })->get();
    }

    /**
     * @param array $params
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function paginatePublishedGirls($params=[])
    {
        return self::publishedGirlsDefault($params)
            ->where('type', Girl::TYPE_GIRLS)
            ->orderBy('created_at', 'desc')
            ->paginate(21);
    }

    public function paginate(int $count, array $params = [])
    {
        $filter = new GirlsFilter($params);
        $query = Girl::filter($filter)
            ->withCount('clientApplications')
            ->withCount('reviews');

        if(array_key_exists('sort', $params)) {
            $order = $params['sortOrder'] ?? 'desc';

            if(in_array($params['sort'], [
                'id',
                'user_id',
                'created_at',
                'country_id',
                'city_id',
                'status',
                'reviews_count',
                'client_applications_count'
            ])) {
                $query->orderBy($params['sort'], $order);
            }
        }

        return $query->orderBy('id', 'desc')
            ->paginate($count);
    }

    /**
     * @param array $params
     * @param int $count
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getRandomGirls(array $params, int $count=12)
    {
        return self::publishedGirlsDefault($params)
            ->where('type', Girl::TYPE_GIRLS)
            ->inRandomOrder()
            ->limit($count)
            ->get();
    }

    public function getRandomGirlsForCountry(Country $country, $without_girl_id)
    {
        return Cache::remember('similar_for_girl_'.$without_girl_id, 10, function () use ($country, $without_girl_id) {
            return Girl::where('status', Girl::STATUS_PUBLISHED)
                ->inCountry($country)
                ->where('id', '!=', $without_girl_id)
                ->inRandomOrder()
                ->limit(10)
                ->get();
        });
    }

    /**
     * @param GirlCreateDto
     * @return Girl
     * @throws ValidationException
     * @throws \Throwable
     */
    public function create(GirlCreateDto $dto): Girl
    {
        $violations = $this->validator->validate($dto);

        if(count($violations) > 0) {
            throw new ValidationException((string) $violations);
        }

        if($dto->getCity()->country_id != $dto->getCountry()->id)
            throw new ValidationException('The city does not belong to the country');

        $girl = new Girl;

        $girl->name = $dto->getName();
        $girl->real_name = $dto->getRealName();
        $girl->pornstar = $dto->getPornstar();
        $girl->phone = $dto->getPhone();
        $girl->age = $dto->getAge();
        $girl->weight = $dto->getWeight();
        $girl->height = $dto->getHeight();
        $girl->bust = $dto->getBust();
        $girl->weight = $dto->getWeight();
        $girl->waist= $dto->getWaist();
        $girl->hip = $dto->getHip();
        if (Auth::user()->isAdmin()) {
            $girl->vip = $dto->getVip();
        }

        // проставляем переводы
        $translations_array = [];
        foreach ($dto->getAbout() as $translation)
            $translations_array['about:' . $translation->getLocale()] = $translation->getValue();

        foreach ($translations_array as $key => $translation) {
            if (trim($translation) == "") {
                $translateFrom = 'en';
                $currentLang = 'ru';
                if ($key == 'about:en') {
                    $translateFrom = 'ru';
                    $currentLang = 'en';
                }
                $tr = app(LingvanexTranslator::class);
                try {
                    $val = $tr->setLanguageFrom($translateFrom)
                    ->setLanguageTo($currentLang)
                    ->setText($translations_array['about:' . $translateFrom])
                    ->translate()->result;
                    $translations_array[$key] = $val;
                } catch(\Exception $e) {
                    \Log::error($e->getMessage());
                }
            }
        }

        $girl->fill($translations_array);

        if($dto->getUser()) {
            $girl->user()->associate($dto->getUser());
        }

        if($dto->getLanguages()) {
            $girl->languages()->sync($dto->getLanguages());
        }

        if($dto->getGeographies()) {
            $girl->geographies()->sync($dto->getGeographies());
        }

        if($dto->getReadyFors()) {
            $girl->readyFors()->sync($dto->getReadyFors());
        }

        if($dto->getWhatLikes()) {
            $girl->whatLikes()->sync($dto->getWhatLikes());
        }

        if ($dto->getProfileSite()) {
            $girl->profileSite()->delete();
            $profileSite = new ProfileSite();
            $profileSite->url = $dto->getProfileSite();
            $girl->profileSite()->save($profileSite);
        } else {
            $girl->profileSite()->delete();
        }

        if($dto->getPossibleCountries()) {
            $girl->possibleCountries()->sync($dto->getPossibleCountries());
        }

        $girl->country()->associate($dto->getCountry());
        $girl->city()->associate($dto->getCity());
        $girl->nationality()->associate($dto->getNationality());
        $girl->orientation()->associate($dto->getOrientation());
        $girl->body()->associate($dto->getBody());
        $girl->bodyHair()->associate($dto->getBodyHair());
        $girl->ethnicity()->associate($dto->getEthnicity());

        $girl->saveOrFail();

        return $girl;
    }

    /**
     * @param User $user
     * @param string $type
     * @return Girl
     * @throws \Throwable
     */
    public function createAgencyModel(User $user, string $type): Girl
    {
        // если есть незаполненная анкета, то выдаем ее
        $girl = Girl::where('user_id', $user->id)
            ->where('status', Girl::STATUS_WAIT)
            ->where('type', $type)
            ->first();

        if ($girl)
            return $girl;

        // создаем новую пустую модель
        $girl = new Girl;
        $girl->status = Girl::STATUS_WAIT;
        $girl->type = $type;
        $girl->user()->associate($user);
        $girl->agency()->associate($user->agency);
        $girl->saveOrFail();

        return $girl;
    }

    /**
     * @param Girl $girl
     * @param User $user
     * @param string $bookmark
     * @return bool
     */
    public function setBookmark(Girl $girl, User $user, string $bookmark): bool {
        try {
            $girl->bookmarks()->updateOrCreate([
                'user_id' => $user->id,
            ], [
                'content' => $bookmark
            ]);
            return true;
        } catch(\Exception $e) {
            \Log::info($e->getMesssage());
            return false;
        }
    }

    /**
     * @param User $user
     * @param string $type
     * @return Girl
     * @throws \Throwable
     */
    public function createGirlModel(User $user, string $type): Girl
    {
        // создаем новую пустую модель
        $girl = new Girl;
        $girl->status = Girl::STATUS_WAIT;
        $girl->type = $type;
        $girl->user()->associate($user);
        $girl->saveOrFail();

        return $girl;
    }

    /**
     * @param Girl $girl
     * @param GirlCreateDto $dto
     * @throws ValidationException
     * @throws \Throwable
     * @return bool
     */
    public function update(Girl $girl, GirlCreateDto $dto)
    {
        $violations = $this->validator->validate($dto);

        if(count($violations) > 0) {
            throw new ValidationException((string) $violations);
        }

        if($dto->getCity()->country_id != $dto->getCountry()->id)
            throw new ValidationException('The city does not belong to the country');

        DB::beginTransaction();

        try {

            $girl->weight = $dto->getWeight();
            $girl->height = $dto->getHeight();
            $girl->bust = $dto->getBust();
            $girl->waist = $dto->getWaist();
            $girl->hip = $dto->getHip();
            $girl->pornstar = $dto->getPornstar();
            $girl->ready_for_travels = $dto->getReadyForTravels();

            if (Auth::user()->isAdmin()) {
                $girl->vip = $dto->getVip();
            }

            if ($dto->getName())
                $girl->name = $dto->getName();

            $girl->real_name = $dto->getRealName();

            if ($newPhone = $dto->getPhone()) {
                // если новый телефон, то генерируем картинку
                if ($girl->phone !== $newPhone) {
                    $girl->phone_image = $this->textToImage->make($newPhone);
                }
                $girl->phone = $newPhone;
            }


            if ($dto->getAge())
                $girl->age = $dto->getAge();

            if ($dto->getUser())
                $girl->user()->associate($dto->getUser());

            if ($dto->getLanguages()) {
                $girl->languages()->sync($dto->getLanguages());
            } else {
                $girl->languages()->sync([]);
            }
            if ($dto->getProfileSite()) {
                $girl->profileSite()->delete();
                $profileSite = new ProfileSite();
                $profileSite->url = $dto->getProfileSite();
                $girl->profileSite()->save($profileSite);
            } else {
                $girl->profileSite()->delete();
            }

            /*if ($dto->getGeographies()) {
                $girl->geographies()->sync($dto->getGeographies());
            } else {
                $girl->geographies()->sync([]);
            }*/

            if($dto->getReadyFors()) {
                $girl->readyFors()->sync($dto->getReadyFors());
            } else {
                $girl->readyFors()->sync([]);
            }

            if($dto->getWhatLikes()) {
                $girl->whatLikes()->sync($dto->getWhatLikes());
            } else {
                $girl->whatLikes()->sync([]);
            }

            if ($dto->getPossibleCountries()) {
                $girl->possibleCountries()->sync($dto->getPossibleCountries());
            } else {
                $girl->possibleCountries()->sync([]);
            }

            if ($dto->getContactMethods()) {
                $girl->contactMethods()->sync($dto->getContactMethods());
            } else {
                $girl->contactMethods()->sync([]);
            }

            if ($dto->getMeetingPoints()) {
                $girl->meetingPoints()->delete();
                foreach ($dto->getMeetingPoints() as $meetingPoint) {
                    $girl->meetingPoints()->create([
                        'type' => $meetingPoint->getType(),
                        'place' => $meetingPoint->getPlace(),
                    ]);
                }
            } else {
                $girl->meetingPoints()->delete();
            }

            if ($costs = $dto->getCosts()) {
                $girl->costs()->delete();
                foreach ($costs as $cost) {
                    $girl->costs()->create([
                        'amount' => $cost->getAmount(),
                        'currency_id' => $cost->getCurrencyId(),
                        'duration' => $cost->getDuration(),
                    ]);
                }
            } else {
                $girl->costs()->delete();
            }

            if ($meetingWiths = $dto->getMeetingWith()) {
                $girl->meetingWith()->delete();
                foreach ($meetingWiths as $type) {
                    $girl->meetingWith()->create([
                        'type' => $type,
                    ]);
                }
            } else {
                $girl->meetingWith()->delete();
            }

            $girl->country()->associate($dto->getCountry());
            $girl->city()->associate($dto->getCity());
            $girl->nationality()->associate($dto->getNationality());
            $girl->orientation()->associate($dto->getOrientation());
            $girl->body()->associate($dto->getBody());
            $girl->bodyHair()->associate($dto->getBodyHair());
            $girl->ethnicity()->associate($dto->getEthnicity());
            $girl->hair()->associate($dto->getHair());
            $girl->eye()->associate($dto->getEye());

            // проставляем переводы
            $translations_array = [];
            foreach ($dto->getAbout() as $translation)
                $translations_array['about:' . $translation->getLocale()] = $translation->getValue();

            foreach ($translations_array as $key => $translation) {
                if (trim($translation) == "") {
                    $translateFrom = 'en';
                    $currentLang = 'ru';
                    if ($key == 'about:en') {
                        $translateFrom = 'ru';
                        $currentLang = 'en';
                    }

                    $tr = app(LingvanexTranslator::class);
                    try {
                        $val = $tr->setLanguageFrom($translateFrom)
                            ->setLanguageTo($currentLang)
                            ->setText($translations_array['about:' . $translateFrom])
                            ->translate()->result;
                        $translations_array[$key] = $val;
                    } catch(\Exception $e) {
                        \Log::error($e->getMessage());
                    }
                }
            }
            $girl->fill($translations_array);

            $result = $girl->saveOrFail();
            DB::commit();
            return $result;
        } catch (\Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
    }

    /**
     * @param $user_id
     * @return Girl
     * @throws ModelNotFoundException
     */
    public function getIndependentForUser($user_id): Girl
    {
        return Girl::with('country', 'city')
            ->where('user_id', $user_id)
            ->firstOrFail();
    }

    /**
     * @param $user_id
     * @return Girl
     * @throws ModelNotFoundException
     */
    public function getGirlsForUser($user_id): Girl
    {
        return Girl::where('user_id', $user_id)
            ->get();
    }

    /**
     * @param UploadedFile $file
     * @param Girl $girl
     * @return Media
     * @throws \Exception
     */
    public function uploadCover(UploadedFile $file, Girl $girl): Media
    {
        // удаляем прошлую заставку
        $girl->clearMediaCollection('cover');
        // выставляем новую
        return $girl->addMedia($file)
            ->usingFileName(md5(random_bytes(6)) . '.' . $file->extension())
            ->toMediaCollection('cover');
    }

    /**
     * @param UploadedFile $file
     * @param Girl $girl
     * @return Media
     * @throws \Exception
     */
    public function uploadPhoto(UploadedFile $file, Girl $girl): Media
    {
        $added_media = $girl->addMedia($file)
            ->usingFileName(md5(random_bytes(6)) . '.' . $file->extension())
            ->toMediaCollection(Girl::PUBLIC_PHOTOS);

        // проставляем как аватарку, если еще нет проставленной аватарки
        $avatar = $girl->getFirstMedia(Girl::PUBLIC_PHOTOS, ['avatar' => true]);
        if(!$avatar) {
            $added_media->setCustomProperty('avatar', true)->save();
        }

        // публикуем анкету
        $girl->publish();

        return $added_media;
    }

    /**
     * @param Girl $girl
     * @return bool
     * @throws \Exception
     */
    public function addToFavourite (Girl $girl): bool
    {
        try {
            Auth::user()->favourites()->attach($girl->id);
        } catch (\Exception $exception) {
            return false;
        }
        return true;
    }

    /**
     * @param Girl $girl
     * @return bool
     * @throws \Exception
     */
    public function removeFromFavourites (Girl $girl): bool
    {
        try {
            Auth::user()->favourites()->detach($girl->id);
        } catch (\Exception $exception) {
            return false;
        }
        return true;
    }

    /**
     * @param UploadedFile $file
     * @param Girl $girl
     * @return Media
     * @throws \Exception
     */
    public function uploadVideo(UploadedFile $file, Girl $girl): Media
    {
        $added_media = $girl->addMedia($file)
            ->usingFileName(md5(random_bytes(6)) . '.' . $file->extension())
            ->toMediaCollection(Girl::PUBLIC_VIDEOS);

        return $added_media;
    }

    /**
     * @param UploadedFile $file
     * @param Girl $girl
     * @return Document
     * @throws \Throwable
     */
    public function uploadDocument(UploadedFile $file, Girl $girl): Document
    {
        // если уже есть документ, то удаляем его
        DB::beginTransaction();

        try {
            if ($girl->document)
                $girl->document->delete();
            $document = new Document;
            $document->girl()->associate($girl);
            $document->saveOrFail();
            $document->addMedia($file)
                ->usingFileName(md5(random_bytes(6)) . '.' . $file->extension())
                ->toMediaCollection(Document::MEDIA_COLLECTION);

            // выставляем режим проверки анкеты
            $girl->setWaitVerify();

            DB::commit();

            return $document;
        } catch (\Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
    }

    /**
     * @param Girl $girl
     * @param $media_id
     * @return bool
     */
    public function removePhoto(Girl $girl, $media_id): bool
    {
        try {
            /** @var Media $media */
            $media = Media::where([
                'model_type' => get_class($girl),
                'model_id' => $girl->id,
                'id' => $media_id
            ])->firstOrFail();
            $is_avatar = $media->getCustomProperty('avatar', false);
            $media->delete();

            // если это аватарка, то пробуем поставить другую аватаркой,иначе ставим аккаунт в режим ожидания
            if($is_avatar) {
                $media = Media::where([
                    'model_type' => get_class($girl),
                    'model_id' => $girl->id
                ])->first();
                if ($media) {
                    $media->setCustomProperty('avatar', true)->save();
                } else {
                    $girl->wait();
                }
            }
        } catch (\Exception $exception) {
            return false;
        }
        return true;
    }

    /**
     * @param Girl $girl
     * @param $media_id
     * @return bool
     */
    public function removeVideo(Girl $girl, $media_id): bool
    {
        try {
            /** @var Media $media */
            $media = Media::where([
                'model_type' => get_class($girl),
                'model_id' => $girl->id,
                'id' => $media_id
            ])->firstOrFail();
            $media->delete();
        } catch (\Exception $exception) {
            return false;
        }
        return true;
    }

    /**
     * @param Girl $girl
     * @param $media_id
     * @return bool
     */
    public function setAvatar(Girl $girl, $media_id): bool
    {
        try {
            $media = Media::where([
                'model_type' => get_class($girl),
                'model_id' => $girl->id,
                'id' => $media_id
            ])->firstOrFail();

            // прошлую аватарку убираем
            $previous_avatar = $girl->getFirstMedia(Girl::PUBLIC_PHOTOS, ['avatar' => true]);
            if($previous_avatar)
                $previous_avatar->setCustomProperty('avatar', false)->save();
            // выбранную фотку ставим аватаркой
            $media->setCustomProperty('avatar', true)->save();
            // пробуем активировать профиль
            // $girl->activate();
        } catch (\Exception $exception) {
            return false;
        }
        return true;
    }

    public function uploadHiddenPhoto(string $base64image, Girl $girl)
    {
        $added_media = $girl->addMediaFromBase64($base64image)
            ->usingFileName(md5(random_bytes(6)) . '.png')
            ->toMediaCollection(Girl::PUBLIC_PHOTOS);

        // проставляем как аватарку, если еще нет проставленной аватарки
        $avatar = $girl->getFirstMedia(Girl::PUBLIC_PHOTOS, ['avatar' => true]);
        if(!$avatar) {
            $added_media->setCustomProperty('avatar', true)->save();
        }

        return $added_media;
    }

    /**
     * @param Girl $girl
     * @return bool
     */
    public function publish(Girl $girl): bool
    {
        $result = $girl->publish();
        if($result) {
            // отправляем оповещение
            $girl->user->notify(new SuccessVerification);
        }
        return $result;
    }

    /**
     * @param Girl $girl
     * @return bool
     */
    public function unpublish(Girl $girl, string $reason): bool
    {
        $result = $girl->reject($reason);
        if ($result)
            $girl->user->notify(new FailedPublish($reason));
        return $result;
    }

    /**
     * @param Girl $girl
     * @return bool
     * @throws \Throwable
     */
    public function verify(Girl $girl): bool
    {
        $girl->setVerified();
        // отправляем оповещение
        $girl->user->notify(new SuccessVerification);
        return true;
    }

    /**
     * @param Girl $girl
     * @param GirlRejectVerificationDto $dto
     * @return bool
     */
    public function unverify(Girl $girl, GirlRejectVerificationDto $dto)
    {
        $reason = $dto->getReason();

        $girl->rejectVerification($reason);

        if(strlen($reason['en']) == 0 || strlen($reason['ru']) == 0) {
            $langFrom = 'ru';
            $langTo = 'en';
            if (strlen($reason['ru']) == 0) {
                $langFrom = 'en';
                $langTo = 'ru';
            }
            try {
                $tr = app(LingvanexTranslator::class);

                $val = $tr->setLanguageFrom($langFrom)
                    ->setLanguageTo($langTo)
                    ->setText($reason[$langFrom])
                    ->translate()->result;

                $reason[$langTo] = $val;
            } catch (\Exception $e) {
                \Log::error($e->getMessage());
            }
        }

        $girl->user->notify(new FailedVerification($girl, $reason));
        return true;
    }


    public function addToHidden(Girl $girl, User $user) {
        try {
            $user->hiddenGirls()->attach($girl);
        } catch(\Exception $e) {
            \Log::info($e->getMessage());
            return false;
        }
        return true;
    }

    public function removeFromHidden(Girl $girl, User $user) {
        try {
            $user->hiddenGirls()->detach($girl->id);
        } catch (\Exception $e) {
            return false;
        }
        return true;
    }


    /**
     * @return Girl
     */
    public function hidden(User $user)
    {
        return $user->hiddenGirls;
    }


    public function byVerification($params = []) {

        $filter = new GirlsFilter($params);
        $query = Girl::filter($filter);

        if(array_key_exists('sort', $params)) {
            $order = $params['sortOrder'] ?? 'desc';

            if(in_array($params['sort'], [
                'id',
                'user_id',
                'created_at',
                'verified_at',
                'verified',
            ])) {
                $query->orderBy($params['sort'], $order);
            }
        }

        return $query->orderBy('id', 'desc')->paginate();
    }

    public function makeVip(Girl $girl, $days = 30) {
        $girl->setVip();
        \Log::info($days);
        $girl->extendVipDays($days);

        $girl->save();

        return $girl;
    }

    public function removeVip(Girl $girl) {
        $girl->vip = 0;
        $girl->vip_end_date = null;

        $girl->save();

        return $girl;
    }
}
