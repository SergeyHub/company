<?php

namespace App\Filters;

use App\Entity\Girl\Girl;

class GirlsFilter extends BaseFilter
{
    public function query($value)
    {
        $this->builder->where(function ($query) use ($value) {
            $query->where('id', $value)
                ->orWhere('name', 'like', '%'.$value.'%');

            if(strpos($value, '@')) {
                $query->orWhereHas('user', function ($query) use ($value) {
                    $query->where('email', 'like', '%' . $value . '%');
                });
            }

            if(strlen($value) >= 5) {
                $query->orWhere('phone', 'like', "%$value%");
            }
        });
    }

    public function status($value)
    {
        if(!is_array($value)) {
            $this->builder->where('girls.status', $value);
        } else {
            $this->builder->whereIn('girls.status', $value);
        }
    }

    public function verified($value)
    {
        if($value == 1) $value = Girl::VERIFY_YES;
        $this->builder->where('verified', $value);
    }

    public function ready_for_travels($value)
    {
        if(!is_array($value)) {
            $this->builder->where('girls.ready_for_travels', $value);
        } else {
            $this->builder->whereIn('girls.ready_for_travels', $value);
        }
    }

    public function age_from($value)
    {
        $this->builder->where('girls.age', '>=', $value);
    }

    public function age_to($value)
    {
        $this->builder->where('girls.age','<=',  $value);
    }

    public function height_from($value)
    {
        $this->builder->where('girls.height','>=',  $value);
    }

    public function height_to($value)
    {
        $this->builder->where('girls.height','<=',  $value);
    }

    public function hairs($value)
    {
        if(!is_array($value)) {
            $this->builder->where('girls.hair_id', $value);
        } else {
            $this->builder->whereIn('girls.hair_id', $value);
        }
    }

    public function nationality($value)
    {
        if(!is_array($value)) {
            $this->builder->where('girls.nationality_id', $value);
        } else {
            $this->builder->whereIn('girls.nationality_id', $value);
        }
    }

    public function city($value)
    {
        if(!is_array($value)) {
            $this->builder->where('girls.city_id', $value);
        } else {
            $this->builder->whereIn('girls.city_id', $value);
        }
    }

    public function agency($value)
    {
        if(!is_array($value)) {
            $this->builder->where('girls.agency_id', $value);
        } else {
            $this->builder->whereIn('girls.agency_id', $value);
        }
    }

    public function country($value)
    {
        if(!is_array($value)) {
            $this->builder->where('girls.country_id', $value);
        } else {
            $this->builder->whereIn('girls.country_id', $value);
        }
    }


    public function created_from($value) {
        $this->builder->where('created_at', '>=', $value);
    }

    public function created_to($value) {
        $this->builder->where('created_at', '<=', $value);
    }

    public function verificated_from($value) {
        $this->builder->where('verified_at', '>', $value);
    }

    public function verificated_to($value) {
        $this->builder->where('verified_at', '<', $value);
    }

    public function verification_applicated_from($value) {
        $this->builder->whereHas('document', function($query) use($value) {
            $query->where('created_at', '>', $value);
        });
    }

    public function verification_applicated_to($value) {
        $this->builder->whereHas('document', function($query) use($value) {
            $query->where('created_at', '<', $value);
        });
    }

    public function vip($value) {
        if($value == 'true') {
            $value = 1;
        } elseif($value == 'false') {
            $value = 0;
        }
        $this->builder->where('vip', $value);
    }
}
