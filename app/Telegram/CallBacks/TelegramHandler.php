<?php

namespace App\Telegram\CallBacks;

use DefStudio\Telegraph\Models\TelegraphChat;

trait TelegramHandler
{
    /**
     * @return mixed
     */
    private function getChat()
    {
        return TelegraphChat::where('chat_id', $this->chat->chat_id)->first();
    }

}
