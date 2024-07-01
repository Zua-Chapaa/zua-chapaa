<?php

namespace App\Telegram\CallBacks\Home;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Stringable;

trait Home
{
    public function select_plan(): void
    {
        $this->getChat()->storage()->set('user_context', "phone_number_request_mode");

        $this?->getChat()
            ->message("Please Enter your number to proceed")
            ->send();
    }

    public function validateNumber(Stringable $text): mixed
    {
        Log::info($text);
        return true;
    }
}
