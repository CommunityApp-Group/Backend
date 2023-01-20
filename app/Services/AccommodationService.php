<?php
namespace App\Services;

use App\Models\Accommodation;
use Illuminate\Pipeline\Pipeline;
use App\Filters\AccommodationFilter\Category;
use App\Filters\AccommodationFilter\AccommodationName;

class AccommodationService
{
    public static function retrieveMyAccommodation() {
        $accommodation_filter = app(Pipeline::class)
            ->send(Accommodation::where('user_id',  auth()->guard('admin')->id()))
            ->through([
                Category::class,
                AccommodationName::class
            ])
            ->thenReturn();
        return $accommodation_filter;
    }

    public static function retrievePopularAccommodation() {
        $accommodation_filter = app(Pipeline::class)
            ->send(Accommodation::where('user_id',  auth()->id()))
            ->through([
                Category::class,
                AccommodationName::class
            ])
            ->thenReturn();
        return $accommodation_filter;
    }
}