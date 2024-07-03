<?php

namespace App\Http\Controllers;

use DefStudio\Telegraph\Models\TelegraphChat;

//use Illuminate\Http\Request;

class MpesaController extends Controller
{

    public function sendRequest(TelegraphChat $chat): void
    {
        $chat->message("request sent...")->send();
    }
}
