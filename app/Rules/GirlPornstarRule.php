<?php

namespace App\Rules;

use App\Entity\Girl\Girl;
use Illuminate\Contracts\Validation\Rule;

class GirlPornstarRule implements Rule
{

    /** @var int */
    protected $girl_id;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($girl_id)
    {
        $this->girl_id = $girl_id;
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
        if (!$value) {
            return true;
        }

        $girl = Girl::find($this->girl_id);
        if ($value && ($girl->isVerified() || $girl->isWaitVerify())) {
            return true;
        }
        return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Pornstar is not verified';
    }

}
