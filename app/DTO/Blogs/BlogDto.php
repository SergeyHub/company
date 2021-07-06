<?php

namespace App\DTO\Blogs;

use App\DTO\BaseDto;
use App\Entity\Clients\Client;
use App\Entity\Geo\City\City;
use App\Entity\Geo\Country\Country;
use App\ValueObjects\Translation;
use Illuminate\Http\UploadedFile;

class BlogDto extends BaseDto {

    /** @var Translation[]|null */
    private $title;

    /** @var Translation[]|null */
    private $content;

    /** @var Translation[]|null */
    private $short_description;

    /** @var string|null */
    private $slug;

    /** @var UploadedFile|null */
    private $cover;

    /**
     * @return UploadedFile|null
     */
    public function getCover(): ?UploadedFile
    {
        return $this->cover;
    }

    /**
     * @param UploadedFile|null $cover
     */
    public function setCover(?UploadedFile $cover): void
    {
        $this->cover = $cover;
    }

    /**
     * @return Translation[]|null
     */
    public function getTitle(): ?array
    {
        return $this->title;
    }

    /**
     * @param Translation[]|null $title
     */
    public function setTitle(?array $title): void
    {
        $this->title = $title;
    }

    /**
     * @return Translation[]|null
     */
    public function getContent(): ?array
    {
        return $this->content;
    }

    /**
     * @param Translation[]|null $content
     */
    public function setContent(?array $content): void
    {
        $this->content = $content;
    }

    /**
     * @return string|null
     */
    public function getSlug(): ?string
    {
        return $this->slug;
    }

    /**
     * @param string|null $slug
     */
    public function setSlug(?string $slug): void
    {
        $this->slug = $slug;
    }

    /**
     * @return Translation[]|null
     */
    public function getShortDescription(): ?array
    {
        return $this->short_description;
    }

    /**
     * @param Translation[]|null $short_description
     */
    public function setShortDescription(?array $short_description): void
    {
        $this->short_description = $short_description;
    }

}
