<?php

namespace App\Http\Controllers\Api\Auction;

use App\Models\Auction;
use Illuminate\Http\Request;
use App\Traits\GetRequestType;
use App\Services\AuctionService;
use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;
use App\Http\Resources\Auction\AuctionResource;
use App\Http\Requests\Auction\CreateAuctionRequest;
use App\Http\Resources\Auction\AuctionResourceCollection;

class AuctionController extends Controller
{
    use GetRequestType;

    public function __construct()
    {
        $this->middleware('auth.jwt')->except(['index', 'show']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        $auctions = AuctionService::retrieveAuction();
        return $this->getFullAuction($auctions)->additional([
            'message' => 'Auction successfully retrieved',
            'status' => 'success'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return AuctionResource
     */
    public function store(CreateAuctionRequest $request)
    {
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

    /**
     * Display the specified resource.
     *
     * @param Auction $auction
     * @return AuctionResource|AuctionResourceCollection
     */
    public function show(Auction $auction)
    {
        return $this->getSimpleAuction($auction)->additional([
            'message' => 'Auction successfully retrieved',
            'status' => 'success'
        ]);
    }

    /**
     * Display the specified Users resource.
     *
     * @param Auction $auction
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */

    public function myauction(Auction $auction) {
        $auctions = AuctionService::retrieveMyAuction();
        return $this->getMyAuction($auctions)->additional([
            'message' => 'My Auction successfully retrieved',
            'status' => 'success'
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $auction
     * @return AuctionResource
     */
    public function update(CreateAuctionRequest $request, Auction $auction)
    {
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $auction
     * @return \Illuminate\Http\Response
     */
    public function destroy(Auction $auction)
    {
        $user = auth()->user();
        if($auction->user_id !== $user->id) return response()->errorResponse('Permission Denied', [], 403);

        if(!$auction->delete()) {
            return response()->errorResponse('Failed to delete auction');
        }

        return response()->success('Auction deleted successfully');
    }

}
