<?php

namespace App\Http\Controllers;

use DefStudio\Telegraph\Models\TelegraphChat;
use JetBrains\PhpStorm\NoReturn;

class TelegramController extends Controller
{
    #[NoReturn] public function __invoke(): void
    {
        $chat = TelegraphChat::where('name', '[supergroup] Shikisha Kakitu')->first();
        $chat->message("Welcome to the 00:00 Session. Hope you all have fun")->send();
    }


}
