<?php

declare(strict_types=1);

namespace Tests\Setup;

use App\Channel;
use App\Message;
use App\Participant;
use App\User;

class ChannelFactory
{
    protected $participantCount = 0;

    protected $messages = false;

    /**
     * Create a channel with Users and messages.
     *
     * @return Channel
     */
    public function create($overrides = []): Channel
    {
        //Create channel
        $channel = factory(Channel::class)->create($overrides);

        //Add participants * $this->participantCount (default: 0)
        $participants = factory(Participant::class, $this->participantCount)->create([
            'channel_id' => $channel->id,
            'user_id' => factory(User::class),
        ]);

        //Add messages if $messages == true
        if ($this->messages) {
            foreach ($participants as $participant) {
                factory(Message::class)->create([
                    'participant_id' => $participant->id,
                    'channel_id' => $channel->id,
                ]);
            }
        }

        return $channel;
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
