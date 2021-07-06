<?php

namespace App\Rules;

use App\Entity\Bill\Currency\Currency;
use App\Entity\Girl\GirlCost;
use Illuminate\Contracts\Validation\Rule;

class GirlCostsRule implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
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

        foreach ($value as $row) {
            if (!is_array($row))
                return false;

            if (!isset($row['duration']) || !isset($row['currency_id']) || !isset($row['amount']))
                return false;

            if (!preg_match('/^\-?[0-9]+$/', $row['amount']) || $row['amount'] < 0 || $row['amount'] > 100000)
                return false;

            if (!Currency::find($row['currency_id']))
                return false;

            if(!in_array($row['duration'], GirlCost::getDurationsList()))
                return false;
        }

        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Error validation costs';
    }

}
