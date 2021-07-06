<?php

namespace App\Filters;

class UsersFilter extends BaseFilter
{

    public function query($value)
    {
        $this->builder->where('id', $value)
            ->orWhere('email', 'like', '%'.$value.'%');
    }

    public function status($value) {
        if(!is_array($value)) {
            $this->builder->where('status', $value);
        } else {
            $this->builder->whereIn('status', $value);
        }
    }


    public function role($value) {
        if(!is_array($value)) {
            $this->builder->where('role', $value);
        } else {
            $this->builder->whereIn('role', $value);
        }
    }

    public function email_verified($value) {
        if($value == 'false') {
            $this->builder->whereNull('email_verified_at');
        } elseif($value == 'true') {
            $this->builder->whereNotNull('email_verified_at');
        }
    }

    public function type($value) {
        if(!is_array($value)) {
            $this->builder->where('type', $value);
        } else {
            $this->builder->whereIn('type', $value);
        }
    }

    public function created_from($value) {
        $this->builder->where('created_at', '>=', $value);
    }

    public function created_to($value) {
        $this->builder->where('created_at', '<=', $value);
    }

    public function vip($value) {
        if($value == 'true') {
            $value = 1;
        } elseif($value == 'false') {
            $value = 0;
        }
        $this->builder->whereHas('ownGirls', function($girls) use ($value) {
            $girls->where('vip', $value);
        });
    }
}
