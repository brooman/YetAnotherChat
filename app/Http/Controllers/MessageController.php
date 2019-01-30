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
            'conversation_id' => 'required|int',
            'content' => 'required|string',
        ]);

        //Participation check
        $check = Participant::where([
            'user_id' => auth()->user()->id,
            'conversation_id' => $request->conversation_id,
        ])->exists();

        if ($check) {
            $message = new Message([
                'user_id' => auth()->user()->id,
                'conversation_id' => $request->conversation_id,
                'content' => $request->content,
            ]);

            $message->save();

            return response()->json(['message' => 'Successfully added message'], 200);
        } else {
            return response()->json(['error' => 'You are not part of that conversation'], 401);
        }
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
        try {
            $message = Message::where([
                'id' => $request->message_id,
                'user_id' => auth()->user()->id,
            ])->firstOrFail();

            $message->content = $request->content;

            $message->save();

            return response()->json(['message' => 'Successfully updated message'], 200);
        } catch (Exception $e) {
            return response()->json(['error' => 'Can\'t find message'], 401);
        }
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

        try {
            $message = Message::where([
                'id' => $request->message_id,
                'user_id' => auth()->user()->id,
            ])->delete();

            return response()->json(['message' => 'Successfully deleted message'], 200);
        } catch (Exception $e) {
            return response()->json(['error' => 'Message does not exist'], 401);
        }
    }
}
