<?php

namespace App\Rules;

use App\Models\Auction;
use Illuminate\Contracts\Validation\Rule;

class GreaterThanMaxBid implements Rule
{
    private ?Auction $auction;
    private int $currentMaxBid;

    public function __construct(?string $auctionId)
    {
        $this->auction = Auction::find($auctionId);
    }

    /**
     * The value must be greater than the maximum bid or the starting price of the auction.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $this->currentMaxBid = $this->auction->bids()->max('price') ?? $this->auction->start_price - 1;
        return (int)$value > $this->currentMaxBid;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return "The bid must be greater than $this->currentMaxBid";
    }
}
