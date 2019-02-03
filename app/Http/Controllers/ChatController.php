<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Channel;
use App\Participant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * Store a created channel.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'    => 'required|string|max:64',
            'users.*' => 'int|exists:users,id|nullable',
        ]);

        //Create channel
        $channel = new Channel([
            'name' => $request->name,
        ]);

        $channel->save();

        //Add participants
        $participants = new Participant([
            'channel_id' => $channel->id,
            'user_id'    => auth()->user()->id,
        ]);

        foreach ($request->users as $user) {
            $participants::create([
                'channel_id' => $channel->id,
                'user_id'    => $user,
            ]);
        }

        $participants->save();

        //Create response
        return response()->json([
            'id'      => $channel->id,
            'name'    => $channel->name,
            'message' => 'Successfully created.',
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
    }
}
