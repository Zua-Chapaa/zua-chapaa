<?php

namespace App\Telegram\CallBacks\Home;

trait Home
{
    public function select_plan(): void
    {
        $this?->getChat()
            ->message("Please Enter your number to proceed");
    }
}
