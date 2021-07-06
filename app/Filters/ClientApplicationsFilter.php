<?php

namespace App\Filters;

class ClientApplicationsFilter extends BaseFilter
{
    public function query($value)
    {
        $this->builder->where('id', $value);
    }

    public function girl_query($value)
    {
        $this->builder->whereHas('girl', function($girls) use($value) {
            $girls->where('id', $value)
                ->orWhere('name', 'LIKE', '%'. $value. '%')
                ->orWhereHas('user', function($query) use($value) {
                    $query->where('email', 'LIKE', '%'. $value .'%');
                });
        });
    }

    public function type($value) {
        $this->builder->whereHas('userTo', function($user) use($value) {
            if(!is_array($value)) {
                $user->where('type', $value);
            } else {
                $user->whereIn('type', $value);
            }
        });
    }

    public function phone($value) {
        $this->builder->where('phone', 'LIKE', '%'. $value .'%');
    }

    public function created_from($value) {
        $this->builder->where('created_at', '>=', $value);
    }

    public function created_to($value) {
        $this->builder->where('created_at', '<=', $value);
    }
}
