<?php

namespace App\Http\Controllers\Api\Auction;

use App\Models\Auction;
use Illuminate\Http\Request;
use App\Traits\GetRequestType;
use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;
use App\Http\Resources\Auction\AuctionResource;
use App\Http\Requests\Auction\CreateAuctionRequest;
use App\Services\AuctionService;

class AuctionController extends Controller
{
    use GetRequestType;

    public function __construct()
    {
        $this->middleware('auth.jwt')->except(['index']);
    }

    public function index() {
        $auctions = AuctionService::retrieveAuction();
        return $this->getFullAuction($auctions)->additional([
            'message' => 'Auction successfully created',
            'status' => 'success'
        ]);
    }

    public function store(CreateAuctionRequest $request) {
        try {
            if(!$auction = $request->createAuction()) {
                return response()->errorResponse('Failed to create auction! Please try again later');
            }

            return (new AuctionResource($auction))->additional([
                'message' => 'Auction successfully created',
                'status' => 'success'
            ]);
        } catch(QueryException $e) {
            report($e);
            return response()->errorResponse('Failed to create auction! Please try again later');
        }
    }

    public function show(Auction $auction) {
        return (new AuctionResource($auction))->additional([
            'message' => 'Auction successfully retrieved',
            'status' => 'success'
        ]);
    }

    public function update(CreateAuctionRequest $request, Auction $auction) {
        $user = auth()->user();
        if($auction->user_id !== $user->id) return response()->errorResponse('Permission Denied', [], 403);

        if(!$update_auction = $auction->update(
            $request->validated()
        )) {
            return response()->errorResponse('Auction Update Failed');
        }

        return (new AuctionResource($auction))->additional([
            'message' => 'Auction successfully updated',
            'status' => 'success'
        ]);
    }

    public function destroy(Auction $auction) {
        $user = auth()->user();
        if($auction->user_id !== $user->id) return response()->errorResponse('Permission Denied', [], 403);
        
        if(!$auction->delete()) {
            return response()->errorResponse('Failed to delete auction');
        }

        return response()->success('Auction deleted successfully');
    }
}
