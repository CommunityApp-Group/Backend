<?php
namespace App\Filters\ProductFilter;

use App\Filters\BaseFilter;

class ProductName extends BaseFilter {

    protected function applyFilter($builder)
    {
        $name = request($this->filterName());
        $builder->where($this->filterName(), 'like', '%' . $name . '%');

        return $builder;
    }
}
