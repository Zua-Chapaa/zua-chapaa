<?php

namespace App\Telegram;

use App\Telegram\CallBacks\GetChat;

trait message
{
    use GetChat;

    public function msg($msg): void
    {
        $this->getChat()->message($msg)->send();
    }
}
