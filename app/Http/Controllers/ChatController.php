<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Conversation;
use App\Participant;

class ChatController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a created conversation.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:64',
            'users.*' => 'int|exists:users,id|nullable',
        ]);

        //Create conversation
        $conversation = new Conversation([
            'name' => $request->name,
        ]);

        $conversation->save();

        //Add participants
        $participants = new Participant([
            'conversation_id' => $conversation->id,
            'user_id' => auth()->user()->id,
        ]);

        foreach ($request->users as $user) {
            $participants::create([
                'conversation_id' => $conversation->id,
                'user_id' => $user,
            ]);
        }

        $participants->save();

        //Create response
        return response()->json([
            'id' => $conversation->id,
            'name' => $conversation->name,
            'message' => 'Successfully created.',
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
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
