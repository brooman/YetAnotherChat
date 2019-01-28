<?php

namespace Tests\Setup;

use App\Conversation;
use App\Participant;
use App\User;
use App\Message;

class ConversationFactory
{
    protected $participantCount = 0;

    protected $messages = false;

    /**
     * Create a conversation with Users and messages.
     *
     * @return Conversation
     */
    public function create($overrides = []): Conversation
    {
        //Create conversation
        $conversation = factory(Conversation::class)->create($overrides);

        //Add participants * $this->participantCount (default: 0)
        $participants = factory(Participant::class, $this->participantCount)->create([
            'conversation_id' => $conversation->id,
            'user_id' => factory(User::class),
        ]);

        //Add messages if $messages == true
        if ($this->messages) {
            foreach ($participants as $participant) {
                factory(Message::class)->create([
                    'user_id' => $participant->user_id,
                    'conversation_id' => $conversation->id,
                ]);
            }
        }

        return $conversation;
    }

    /**
     * Create participants.
     *
     * @param int $count
     *
     * @return self
     */
    public function withParticipants(int $count): self
    {
        $this->participantCount = $count;

        return $this;
    }

    public function withMessages(): self
    {
        $this->messages = ! $this->messages;

        return $this;
    }
}
