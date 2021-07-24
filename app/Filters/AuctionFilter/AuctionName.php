<?php
namespace App\Filters\AuctionFilter;

use App\Filters\BaseFilter;

class AuctionName extends BaseFilter {

    protected function applyFilter($builder)
    {
        $name = request($this->filterName());
        $builder->where($this->filterName(), 'like', '%' . $name . '%');

        return $builder;
    }
}