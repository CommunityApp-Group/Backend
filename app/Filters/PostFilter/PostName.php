<?php
namespace App\Filters\PostFilter;

use App\Filters\BaseFilter;

class d PostName extends BaseFilter {

    protected function applyFilter($builder)
    {
        $name = request($this->filterName());
        $builder->where($this->filterName(), 'like', '%' . $name . '%');

        return $builder;
    }
}
