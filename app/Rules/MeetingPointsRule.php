<?php

namespace App\Rules;

use App\Entity\Girl\GirlMeetingPoint;
use Illuminate\Contracts\Validation\Rule;

class MeetingPointsRule implements Rule
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

            if (!isset($row['type']) || !isset($row['place']))
                return false;

            if(!in_array($row['type'], GirlMeetingPoint::getTypesList()))
                return false;

            if(!in_array($row['place'], GirlMeetingPoint::getPlacesList()))
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
        return 'Meeting points validation error';
    }
}
