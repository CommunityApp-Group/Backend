<?php
namespace App\Filters\StoryFilter;

use App\Filters\BaseFilter;

class StoryName extends BaseFilter {

    protected function applyFilter($builder)
    {
        $name = request($this->filterName());
        $builder->where($this->filterName(), 'like', '%' . $name . '%');

        return $builder;
    }
}
