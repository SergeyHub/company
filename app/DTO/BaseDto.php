<?php

namespace App\DTO;

use Illuminate\Support\Str;

class BaseDto
{

    public function __construct($params = array()) {
        foreach ($params as $key => $value) {
            if(!property_exists($this, $key) || $value === null)
                continue;
            $method_name = 'set'.ucfirst(Str::camel($key));
            if(method_exists($this, $method_name))
                call_user_func(array($this, $method_name), $value);
        }
    }

}
