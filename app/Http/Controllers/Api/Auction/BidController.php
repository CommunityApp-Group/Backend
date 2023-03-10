<?php

namespace App\Http\Controllers\Api\Auction;

use App\Http\Controllers\Controller;
use App\Http\Resources\Auction\AuctionResource;
use App\Http\Resources\Auction\BidResource;
use App\Models\auctionbid;
use App\Rules\ValidateValidAmount;
use DB;
use Illuminate\Http\Request;

class BidController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth.jwt');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user_id = auth()->user()->id;
        $path = env('FILE_BASE_URL');
        $bids = DB::table('auctions')
            ->select(['auctions.*',DB::raw("CONCAT('".$path."',auctions.auction_image) as image"),'auctionbids.id as auctionbidId','auctionbids.status as status'])
            ->join('auctionbids','auctionbids.auction_id','=','auctions.id')
            ->where('auctionbids.user_id', $user_id)
            ->where( 'auctionbids.deleted_at',  '=',Null)->get();


        if($bids ->count()==0){
            $results = [
                'message' => 'you have no open bid'
            ];

            return response($results,200);
        }else{
            $results = [
                'message' => 'Your bid',
                'Bid Details' => $bids
            ];

            return response($results,200);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            "auction_id" => ['required', 'exists:auctions,id'],
            "price" => ['required', 'numeric', new ValidateValidAmount]
        ]);
        $user_id = auth()->user()->id;
        $exist = Auctionbid::where('user_id',$user_id)->where('auction_id',$request->auction_id)->get()->first();

        if($exist){
            return response(['message'=>'you have already made a bid for this auction'],200);
        }
        $auction = DB::table('auctions')->find($request->auction_id);

        if(!$auction){
            return response(['message'=>'Product not found'],404);
        }
        $bid = Auctionbid::create([
            'user_id' => $user_id,
            'auction_id' => $request->auction_id,
            'price' => $request->price,


        ]);

        $results = [
            'message' => 'Successfully made a bid',
            'Bid' => new BidResource($bid)
        ];

        return response($results,201);
    }

    /**
     * Display the specified resource.
     *
     * @param $bid
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function show(Auctionbid $bid)
    {
        $bids = $bid->user_id ==auth()->user()->id;

        if(!$bids){
            $results = [ 'message' => 'Bid not found' ];
            return response($results,404);
        }

//        $bid_details = DB::table('auctionbids')
//            ->join('auctions', 'auctions.id', '=', 'auctionbids.auction_id')
//            ->where('auctionbids.auction_id', '=', $bid->id)
//            ->select('auctionbids.id','auctionbids.price','auctionbids.status','auctionbids.auction_id','auctions.auction_price','auctions.auction_name','auctions.auction_image')
//            ->get();

        $results = [
            'message' => 'Your bid details',
            'Bid' => new BidResource($bid)
//            'Auction_Details' => $bid_details
        ];

        return response($results,200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param $bid
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Auctionbid $bid)
    {

        $request->validate([
            "price" => ['required', 'numeric', new ValidateValidAmount]
        ]);

        $user_id = auth()->user()->id;

        $bid = Auctionbid::where('user_id',$user_id)->where('id',$bid->id)->get()->first();

        if(!$bid){
            return response(['message'=>'Bid auction not found'],404);
        }


        $bid->update([
            'price' => $request->price,
        ]);


        $results = [
            'message' => 'Successfully Update Bid Price',
            'Bid' => new BidResource($bid)
        ];

        return response($results,201);
    }

    public function updatestatus(Request $request, Auctionbid $bid) {
        $request->validate([
            'status' => 'required|in:bid,won,lost'
        ]);


        $bid->status = $request->status;
        $bid->save();

        if(!$bid->wasChanged()) {
            return response()->errorResponse('Could not update Bid', [
                "errorSource" => "Bid is {$bid->status}"
            ]);
        }


        $results = [
            'message' => 'Bid updated successfully',
            'Bid' => new BidResource($bid)
        ];

        return response($results,201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $bid
     * @return \Illuminate\Http\Response
     */
    public function destroy(Auctionbid $bid)
    {
        $user_id = auth()->user()->id;
        $bid = Auctionbid::where('user_id',$user_id)->where('id',$bid->id)->get()->first();

        if(!$bid){
            $results = [ 'message' => 'bid not found' ];
            return response($results,404);
        }
        $bid->delete();
        $results = [ 'message' => 'Successfully deleted the Bid' ];
        return response($results,200);
    }
}
