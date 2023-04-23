<?php

namespace App\Listeners;

use App\Events\AuctionPurchasedEvent;
use App\Mail\Purchases\AuctionBought;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class NotifyBuyer
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param AuctionPurchasedEvent $event
     * @return void
     */
    public function handle(AuctionPurchasedEvent $event)
    {
        Mail::to($event->buyer)
            ->send(new AuctionBought($event->auction, $event->purchase->price));
    }
}
