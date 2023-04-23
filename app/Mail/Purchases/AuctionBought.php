<?php

namespace App\Mail\Purchases;

use App\Models\Auction;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AuctionBought extends Mailable
{
    use Queueable, SerializesModels;
    public Auction $auction;
    public int $price;
    /**
     * Create a new message instance.
     *
     * @param Auction $auction
     * @param int $price
     */
    public function __construct(Auction $auction, int $price)
    {
        $this->auction = $auction;
        $this->price = $price;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.purchases.auction-bought');
    }
}
