<?php

namespace App\Filters;

class OffersFilter extends BaseFilter
{

    public function status($value)
    {
        if(!is_array($value)) {
            $this->builder->where('offers.status', $value);
        } else {
            $this->builder->whereIn('offers.status', $value);
        }
    }

}
