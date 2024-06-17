<?php

namespace App\Telegram;

use DefStudio\Telegraph\Models\TelegraphBot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use PHPUnit\Event\Code\Throwable;
use Stringable;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class WebHookHandler extends \DefStudio\Telegraph\Handlers\WebhookHandler
{
//    public function handle(Request $request, TelegraphBot $bot): void
//    {
//        Log::info("active");
//    }

//    protected function handleChatMessage(Stringable $text): void
//    {
//        // in this example, a received message is sent back to the chat
//        $this->chat->html("Received: $text")->send();
//    }

    public function hi(): void
    {
        $this->chat->markdown('*Hi* happy to be here!')->send();
    }

    /**
     * @throws \Throwable
     */
    protected function onFailure(Throwable|\Throwable $throwable): void
    {
        if ($throwable instanceof NotFoundHttpException) {
            throw $throwable;
        }

        report($throwable);

        $this->reply('sorry man, I failed');
    }
}
