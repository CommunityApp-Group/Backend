<?php
namespace App\Filters\AccommodationFilter;

use App\Filters\BaseFilter;

class Category extends BaseFilter {

    protected function applyFilter($builder)
    {
        $category_name = request($this->filterName());
        $builder->whereIn('accommodations.category_name', function($category) use($category_name) {
            $category->from('categories')
                ->select('category.name')
                ->where('name', $category_name);
        });
        return $builder;
    }
}
