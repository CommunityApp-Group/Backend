<?php
namespace App\Filters\AccommodationFilter;

use App\Filters\BaseFilter;

class AccommodationName extends BaseFilter {

    protected function applyFilter($builder)
    {
        $name = request($this->filterName());
        $builder->where($this->filterName(), 'like', '%' . $name . '%');

        return $builder;
    }
}
