<?php

namespace App\Services;

use App\Http\Requests\Auction\StoreBidRequest;
use App\Models\Bid;
use App\Models\Auction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class MakeBidService
{
    public Bid $bid;
    private StoreBidRequest $request;
    private Auction $auction;

    public function __construct(StoreBidRequest $request)
    {
        $this->request = $request;
        $this->auction = Auction::findOrFail($request->auction);
        $this->storeBid();
    }

    /**
     * Save the bid to the storage
     */
    private function storeBid()
    {
//        Gate::authorize('store-bid', $this->auction);

        DB::transaction(function () {
            Bid::where('user_id', auth()->user()->id)
                ->where('auction_id', $this->request->auction)
                ->update(['is_active' => false]);
            $this->bid = new Bid;
            $this->bid->price = $this->request->bid;
            $this->bid->auction_id = $this->request->auction;
            $this->bid->user_id = auth()->user()->id;
            $this->bid->save();
        });
    }
}
