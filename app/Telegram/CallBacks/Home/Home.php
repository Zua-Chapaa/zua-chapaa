<?php

namespace App\Telegram\CallBacks\Home;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

trait Home
{
    public function select_plan(): void
    {
        Log::info(json_encode(Session::all()));
        $this?->getChat()
            ->message("Please Enter your number to proceed")
            ->send();
    }
}
