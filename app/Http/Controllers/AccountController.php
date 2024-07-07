<?php

namespace App\Http\Controllers;

use DefStudio\Telegraph\Models\TelegraphChat;
use Inertia\Inertia;

class AccountController extends Controller
{
    public TelegraphChat $chat;

    public function account(TelegraphChat $TelegraphChatID): \Inertia\Response
    {
        $this->chat = $TelegraphChatID;

        $name = $this->chat->name;
        $username = str_replace(["[private] ", "[public] "], "", $name);

        return Inertia::render('Telegram/Account', [
            'username' => $username,
        ]);
    }
}
