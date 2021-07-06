<?php

namespace App\ValueObjects;

class Translation
{

    /** @var string */
    protected $locale;

    /** @var string|null */
    protected $value;

    /**
     * Translation constructor.
     * @param string $locale
     * @param string|null $value
     * @throws \InvalidArgumentException
     */
    public function __construct(string $locale='ru', $value=null)
    {
        $locales = config('translatable.locales');
        if(!in_array($locale, $locales))
            throw new \InvalidArgumentException('Invalid locale');

        $this->locale = $locale;
        $this->value = $value;
    }

    /**
     * @return string
     */
    public function getLocale(): string
    {
        return $this->locale;
    }

    /**
     * @return string|null
     */
    public function getValue(): ?string
    {
        return $this->value;
    }

}
