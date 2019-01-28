<?php

namespace YetAnotherChat\Http\Controllers;

use Illuminate\Http\Request;
use YetAnotherChat\Message;
use YetAnotherChat\Participant;

class MessageController extends Controller
{
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
