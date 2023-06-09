<?php

namespace App\Services;

use App\Models\Bid;
use App\Models\User;
use App\Models\Auction;
use App\Models\Purchase;
use Illuminate\Support\Facades\DB;
use App\Events\AUctionPurchasedEvent;

class PurchaseService
{
    private Purchase $purchase;
    private Auction $auction;
    private ?Bid $bid = null;

    public function __construct(Purchase $purchase)
    {
        $this->purchase = $purchase;
    }

    /**
     * Save the purchase to the storage. If there are no bids, return the lot to draft.
     *
     * @param Auction $auction
     */
    public function save(Auction $auction)
    {
        $this->auction = $auction;

        $this->bid = $this->auctionWinnerBid();

        if (isset($this->bid)) {
            $this->confirmAuctionPurchase();
            event(new AuctionPurchasedEvent($this->purchase));
        } else {
            $this->setAuctionStatus('draft');
        }
    }

    /**
     * Make a purchase.
     */
    private function confirmAuctionPurchase()
    {
        DB::transaction(function () {
            $this->storePurchase();

            $this->setAuctionStatus('sold');

            $this->setAllBidsInactive();

            $this->paymentProcess();
        });
    }

    /**
     * Get the maximum lot bid.
     *
     * @return Bid|null
     */
    private function auctionWinnerBid(): ?Bid
    {
        return Bid::where('auction_id', $this->auction->id)->orderBy('price', 'desc')->first();
    }

    /**
     * Set a new lot status.
     *
     * @param string $status
     */
    private function setAUctionStatus(string $status)
    {
        $this->auction->update(['status' => $status]);
    }

    /**
     * Store lot purchase.
     */
    private function storePurchase()
    {
        $this->purchase->auction_id = $this->auction->id;
        $this->purchase->user_id = $this->bid->user_id;
        $this->purchase->price = $this->bid->price;
        $this->purchase->save();
    }

    /**
     * Set all bids for this lot inactive.
     */
    private function setAllBidsInactive()
    {
        Bid::where('lot_id', $this->auction->id)->update(['is_active' => false]);
    }

    /**
     * Increase the seller's balance and decrease the buyer's balance.
     */
    private function paymentProcess()
    {
        User::find($this->bid->user_id)->decrement('balance', $this->bid->price);

        User::find($this->auction->user_id)->increment('balance', $this->bid->price);
    }
}
