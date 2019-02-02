<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Message;
use App\Participant;

class MessageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'channel_id' => 'required|int',
            'content' => 'required|string',
        ]);

        //Get participant
        $participant = Participant::where([
            'user_id' => auth()->user()->id,
            'channel_id' => $request->channel_id,
        ])->first();

        if ($participant) {
            $message = new Message([
                'participant_id' => $participant->id,
                'channel_id' => $request->channel_id,
                'content' => $request->content,
            ]);

            $message->save();

            return response()->json(['message' => 'Successfully added message'], 200);
        }

        return response()->json(['message' => 'You are not a participant in this channel'], 401);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $request->validate([
            'message_id' => 'required|int',
            'content' => 'required|string',
        ]);

        //Message
        $message = Message::with(['participant.user'])->where([
            'id' => $request->message_id,
        ])->first();

        //Ownership check
        if ($message->participant->user->id === auth()->user()->id) {
            $message->content = $request->content;
            $message->save();

            return response()->json(['message' => 'Successfully updated message'], 200);
        }

        return response()->json(['error' => 'Can\'t find message'], 401);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $request->validate([
            'message_id' => 'required|int',
        ]);

        $message = Message::with(['participant.user'])->where([
            'id' => $request->message_id,
        ])->first();

        if ($message->participant->user->id === auth()->user()->id) {
            $message->delete();

            return response()->json(['message' => 'Successfully deleted message'], 200);
        }

        return response()->json(['error' => 'Message does not exist'], 401);
    }
}
