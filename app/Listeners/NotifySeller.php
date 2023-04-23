<?php

namespace App\Listeners;

use App\Events\AuctionPurchasedEvent;
use App\Mail\Purchases\AuctionSold;
use Illuminate\Support\Facades\Mail;


class NotifySeller
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
        Mail::to($event->auction->user)
            ->send(new AuctionSold($event->auction, $event->buyer, $event->purchase->price));
    }
}
