<?php

namespace App\Events;

use App\Models\Bid;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class BidEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public int $auction_id;
    public int $bid_price;
    public int $unique_bids;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Bid $bid)
    {
        $this->auction_id = $bid->auction_id;
        $this->bid_price = $bid->price;
        $this->unique_bids = $bid->auction->number_of_unique_bids;
    }
    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('Bid');
    }

    /**
     * Event name.
     *
     * @return string
     */
    public function broadcastAs()
    {
        return 'NewBid';
    }
}
