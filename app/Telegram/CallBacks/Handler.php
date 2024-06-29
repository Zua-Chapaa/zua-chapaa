<?php

namespace App\Telegram\CallBacks;

use DefStudio\Telegraph\Models\TelegraphChat;

trait Handler
{
    public function __construct()
    {
    }

    private function getChat()
    {
        return TelegraphChat::where('chat_id', $this->chat->chat_id)->first();
    }
}
