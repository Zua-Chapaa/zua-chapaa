<?php

namespace App\Telegram\CallBacks;

use DefStudio\Telegraph\Models\TelegraphChat;

trait GetChat
{
    function getChat($id = null)
    {
        if ($id == null) {
            return TelegraphChat::where('chat_id', $this->chat->chat_id)->first();
        } else {
            return TelegraphChat::where('id', $id)->first();
        }
    }
}
