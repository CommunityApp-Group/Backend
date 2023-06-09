<?php

namespace App\Mail\Purchases;

use App\Models\Auction;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AuctionSold extends Mailable
{
    use Queueable, SerializesModels;

    public Auction $auction;
    public User $buyer;
    public int $price;
    /**
     * Create a new message instance.
     *
     * @param Auction $auction
     * @param User $buyer
     * @param int $price
     */
    public function __construct(Auction $auction, User $buyer, int $price)
    {
        $this->auction = $auction;
        $this->buyer = $buyer;
        $this->price = $price;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.purchases.auction-sold');
    }
}
