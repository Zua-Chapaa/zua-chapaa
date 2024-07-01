<?php

namespace App\Telegram\CallBacks\Home;

use Illuminate\Support\Facades\Log;

trait Home
{
    public function select_plan(): void
    {
        $this->getChat()->storage()->set('user_context', "subscription_mode");

        $this?->getChat()
            ->message("Please Enter your number to proceed")
            ->send();
    }

    public function handlePayment(): mixed
    {
        Log::info("payment");
        return true;
    }
}
