<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;

abstract class BaseFilter
{

    protected $params;

    /** @var Builder */
    protected $builder;

    public function __construct(array $params = [])
    {
        $this->params = $params;
    }

    public function apply(Builder $builder)
    {
        $this->builder = $builder;
        foreach ($this->filters() as $filter => $value) {
            if($value == null || $value == 'null')
                continue;
            if (method_exists($this, $filter)) {
                $this->$filter($value);
            }
        }
        return $this->builder;
    }

    public function filters()
    {
        return $this->params;
    }

}
