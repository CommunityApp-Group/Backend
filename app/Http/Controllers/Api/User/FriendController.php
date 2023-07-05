<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\SendFriendRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Event;
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
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
