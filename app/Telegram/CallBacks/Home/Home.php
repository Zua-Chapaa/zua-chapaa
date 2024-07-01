<?php

namespace App\Telegram\CallBacks\Home;

use Illuminate\Support\Facades\Log;

trait Home
{
    public function select_plan(): void
    {
        Log::info($this->getChat()->storage()->get('language'));
        $this?->getChat()
            ->message("Please Enter your number to proceed")
            ->send();
    }
}
