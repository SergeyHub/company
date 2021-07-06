<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class CheckTranslations implements Rule
{

    /** @var int */
    protected $minlength;

    /** @var int */
    protected $maxlength;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(int $minlength=0, int $maxlength=1024)
    {
        $this->minlength = $minlength;
        $this->maxlength = $maxlength;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if(!is_array($value))
            return false;

        $locales = config('translatable.locales');

        if(count($value) !== count($locales))
            return false;

        // проверяем, все ли языки переданы
        foreach ($locales as $locale) {
            if(!array_key_exists($locale, $value))
                return false;
        }

        $correct_locale_found = false;
        foreach ($locales as $locale) {
            $locale_value_length = strlen($value[$locale]);

            // если длина больше предела, то ошибка
            if($locale_value_length > $this->maxlength) {
                return false;
            }

            // если влезает в рамки, то ок
            if($locale_value_length >= $this->minlength) {
                $correct_locale_found = true;
            }
        }

        return $correct_locale_found;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Incorrect translations';
    }
}
