<?php

namespace App\Http\Controllers;

use DefStudio\Telegraph\Models\TelegraphChat;
use JetBrains\PhpStorm\NoReturn;

class TelegramController extends Controller
{
    #[NoReturn] public function __invoke(): void
    {
        $chat = TelegraphChat::where('name', '[supergroup] Shikisha Kakitu')->first();

        if ($this->has_active_session()) {

        } else {

        }
    }

    private function has_active_session(): bool
    {

    }
}
