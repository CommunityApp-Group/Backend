<?php

namespace App\Services;

use App\Models\Auction;
use Illuminate\Pipeline\Pipeline;
use App\Filters\AuctionFilter\AuctionName;
use App\Filters\AuctionFilter\Category;

class AuctionService 
{
    public static function retrieveAuctionOnsale() {
        $auction_filter = app(Pipeline::class)
            ->send(Auction::where('status', 'on sale'))
            ->through([
                Category::class,
                AuctionName::class
            ])
            ->thenReturn();
        return $auction_filter;
    }
    public static function retrieveAuctionSold() {
        $auction_filter = app(Pipeline::class)
            ->send(Auction::where('status', 'sold'))
            ->through([
                Category::class,
                AuctionName::class
            ])
            ->thenReturn();
        return $auction_filter;
    }
    public static function retrieveAuction() {
        $auction_filter = app(Pipeline::class)
                        ->send(Auction::where('verification', 'verified'))
                        ->through([
                            Category::class,
                            AuctionName::class
                        ])
                        ->thenReturn();
        return $auction_filter;
    }
    public static function retrieveActiveAuction() {
        $auction_filter = app(Pipeline::class)
            ->send(Auction::where('verification', 'verified')->where('active', true))
            ->through([
                Category::class,
                AuctionName::class
            ])
            ->thenReturn();
        return $auction_filter;
    }
    public static function retrieveMyAuction() {
        $auction_filter = app(Pipeline::class)
            ->send(Auction::where('user_id',  auth()->id()))
            ->through([
                Category::class,
                AuctionName::class
            ])
            ->thenReturn();
        return $auction_filter;
    }
}
