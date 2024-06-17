<?php

namespace App\Telegram;

use DefStudio\Telegraph\Facades\Telegraph;
use DefStudio\Telegraph\Keyboard\Button;
use DefStudio\Telegraph\Keyboard\Keyboard;
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
    public function start(): void
    {
        $this->chat->markdown('Hello! and welcome to Zua Chapaa')->send();
        Telegraph::message('hello world')
            ->keyboard(Keyboard::make()->buttons([
                Button::make('English')->action('set_language_to_eng'),
                Button::make('Swahili')->action('set_language_to_swahili'),
            ])->chunk(2))->send();
    }

    public function test(): void
    {


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
