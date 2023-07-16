<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\Friend\FriendsResource;
use App\Models\User;
use App\Notifications\SendFriendRequest;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Event;
use Multicaret\Acquaintances\Models\Friendship;
use Notification;

class FriendController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth.jwt');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function index()
    {
        $user = auth()->user()->id;
        $friends = Friendship::where('sender_id',$user)->where('status','accepted')->get()->first();

        if(!$friends){
            $results = [ 'message' => 'you have no friend' ];
            return response($results,404);
        }

        $myfriends = DB::table('friendships')
            ->join('users', 'users.id', '=', 'friendships.recipient_id')
            ->where('friendships.sender_id', '=', $user)
            ->where('status','accepted')
            ->select('users.id','users.firstname','users.lastname','users.avatar')
            ->get();

        $results = [
            'message' => 'Your Friend list',
            'friends' => $myfriends
        ];

        return response($results,200);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function pending()
    {
        $user = auth()->user()->id;
          $friends = Friendship::where('sender_id',$user)->where('status','pending')->get()->first();

        if(!$friends){
            $results = [ 'message' => 'you have no pending friend' ];
            return response($results,404);
        }

        $myfriends = DB::table('friendships')
            ->join('users', 'users.id', '=', 'friendships.recipient_id')
            ->where('friendships.sender_id', '=', $user)
            ->where('status','pending')
            ->select('users.id','users.firstname','users.lastname','users.avatar')
            ->get();

        $results = [
            'message' => 'Your Pending Friend list',
            'friends' => $myfriends
        ];

        return response($results,200);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = auth()->user();
        $sender = User::find(auth()->user());
        $recipient = User::find($request->id);
        $user->befriend($recipient);
        Notification::send($recipient, new SendFriendRequest($user));
 //       Event::dispatch('acq.friendships.sent', [$this, $recipient]);
            $results = [
                'message' => 'friend request sent to ' . $recipient->firstname. " ".$recipient->lastname
            ];
            return response($results,200);
        }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function accept(Request $request)
    {
        $user = auth()->user();
        $sender = User::find(auth()->user());
        $recipient = User::find($request->id);
        $user->acceptFriendRequest($recipient);

  //      Notification::send($recipient, new SendFriendRequest($user));
        //       Event::dispatch('acq.friendships.sent', [$this, $recipient]);
        $results = [
            'message' => 'you have added  ' . $recipient->firstname. " ".$recipient->lastname ." ".'to you friends list'
        ];
        return response($results,200);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function reject(Request $request)
    {
        $user = auth()->user();
        $recipient = User::find($request->id);
        $user->denyFriendRequest($recipient);
        $results = [
            'message' => 'Friend Request denied'
        ];
        return response($results,200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Friend $friend
     * @return \Illuminate\Http\Response
     */
    public function block(Request $request)
    {
        $user = auth()->user();
        $friend = User::find($request->id);
        $user->blockFriend($friend);
        $results = [
            'message' => 'Friend Request denied'
        ];
        return response($results,200);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function unfriend(Request $request)
    {
        $user = auth()->user();
        $sender = User::find(auth()->user());
        $recipient = User::find($request->id);
        $user->unfriend($recipient);

        $results = [
            'message' => 'you have removed ' . $recipient->firstname. " ".$recipient->lastname ." ".'from your friends list'
        ];
        return response($results,200);
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
