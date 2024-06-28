<?php

namespace App\Telegram\CallBacks;

use DefStudio\Telegraph\Models\TelegraphChat;

trait GetChat
{
    function getChat()
    {
        return TelegraphChat::where('chat_id', $this->chat->chat_id)->first();
    }
}
