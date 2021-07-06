<?php

namespace App\Filters;

class ReviewsFilter extends BaseFilter
{

    public function query($value)
    {
        $this->builder->where('model_id', $value)
            ->orWhere('email', 'like', '%'.$value.'%');
    }

    public function published($value) {
        if($value == 'true') $value = 1;
        if($value == 'false') $value = 0;

        $this->builder->where('published', $value);
    }

}
