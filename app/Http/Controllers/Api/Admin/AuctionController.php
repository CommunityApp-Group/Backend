<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Auction\AuctionResource;
use App\Models\Auction;
use Illuminate\Http\Request;

class AuctionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth.jwt:admin');
    }

    public function update(Request $request, Auction $auction) {
        $request->validate([
            'status' => 'required|in:verified,rejected'
        ]);

        $auction->status = $request->status;
        $auction->verified_by = auth()->user()->id;

        $auction->save();

        if(!$auction->wasChanged()) {
            return response()->errorResponse('Could not update auction', [
                "errorSource" => "Auction is {$auction->status}"
            ]);
        }

        return (new AuctionResource($auction))->additional([
            'status' => 'success',
            'message' => 'Auction updated successfully'
        ]);
    }

    public function destroy(Auction $auction) {
        if(!$auction->delete()) {
            return response()->errorResponse('Failed to delete auction');
        }

        return response()->success('Auction deleted successfully');
    }
}
