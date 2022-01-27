<?php

namespace App\Services;

use App\Models\Auction;
use Illuminate\Pipeline\Pipeline;
use App\Filters\AuctionFilter\AuctionName;
use App\Filters\AuctionFilter\Category;

class AuctionService {
    public static function retrieveAuction() {
        $auction_filter = app(Pipeline::class)
                        ->send(Auction::where('status', 'verified'))
                        ->through([
                            Category::class,
                            AuctionName::class
                        ])
                        ->thenReturn();
        return $auction_filter;
    }
}
