<?php

namespace App\Services\Agencies;

use App\DTO\Agencies\AgencyDto;
use App\Entity\Agency\Agency;
use App\Entity\Girl\Girl;
use App\Entity\ProfileSite\ProfileSite;
use App\Services\Images\TextToImage;
use Illuminate\Http\UploadedFile;
use Spatie\MediaLibrary\Models\Media;

class AgencyService
{

    /** @var TextToImage */
    private $textToImage;

    /**
     * AgencyService constructor.
     * @param TextToImage $textToImage
     */
    public function __construct(TextToImage $textToImage)
    {
        $this->textToImage = $textToImage;
    }

    /**
     * @param $id
     * @return Agency
     */
    public function find($id): Agency
    {
        return Agency::findOrFail($id);
    }


    /**
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function paginatePublishedAgencies($params = [])
    {
        $query = Agency::where('status', Agency::STATUS_PUBLISHED)
            ->whereHas('girls', function ($query) {
                $query->where('status', Girl::STATUS_PUBLISHED);
            });

        if(isset($params['country'])) {
            $query = $query->whereHas('countries', function ($query) use ($params) {
                $query->where('country_id', $params['country']);
            });
        }
        
        return $query->orderBy('created_at', 'desc')
            ->paginate(21);
    }


    /**
     * @param $id
     * @return Agency
     * @throws ModelNotFoundException
     */
    public function findPublishedAgency($id): Agency
    {
        $agency = Agency::with( 'geographies')->where('status', Agency::STATUS_PUBLISHED)
            ->findOrFail($id);
        return $agency;
    }

    /**
     * @param Agency $agency
     * @param AgencyDto $dto
     * @return bool
     * @throws \Throwable
     */
    public function update(Agency $agency, AgencyDto $dto): bool
    {
        $agency->name = $dto->getName();

        $newPhone = $dto->getPhone();
        // если новый телефон, то генерируем картинку
        if ($agency->phone !== $newPhone) {
            $agency->phone_image = $this->textToImage->make($newPhone);
        }
        $agency->phone = $newPhone;

        // проставляем переводы
        $translations_array = [];
        foreach ($dto->getDescription() as $translation)
            $translations_array['description:'.$translation->getLocale()] = $translation->getValue();

        $agency->fill($translations_array);

        if ($dto->getContactMethods()) {
            $agency->contactMethods()->sync($dto->getContactMethods());
        } else {
            $agency->contactMethods()->sync([]);
        }

        if ($dto->getProfileSite()) {
            $agency->profileSite()->delete();
            $profileSite = new ProfileSite();
            $profileSite->url = $dto->getProfileSite();
            $agency->profileSite()->save($profileSite);
        } else {
            $agency->profileSite()->delete();
        }

        if ($dto->getGeographies()) {
            $agency->geographies()->sync($dto->getGeographies());
        } else {
            $agency->geographies()->sync([]);
        }

        if ($dto->getCountries()) {
            $agency->countries()->sync($dto->getCountries());
        } else {
            $agency->countries()->sync([]);
        }

        $result = $agency->saveOrFail();
        $agency->publish();
        return $result;
    }

    /**
     * @param Agency $agency
     * @param UploadedFile $file
     * @return Media
     * @throws \Exception
     */
    public function uploadAvatar(Agency $agency, UploadedFile $file): Media
    {
        // если аватарка уже есть, то удаляем ее
        if ($agency->avatar) {
            $agency->avatar->delete();
        }

        $added_media = $agency->addMedia($file)
            ->usingFileName(md5(random_bytes(6)) . '.' . $file->extension())
            ->withCustomProperties(['avatar' => true])
            ->toMediaCollection(Agency::PUBLIC_PHOTOS);

        return $added_media;
    }

}
