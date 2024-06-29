<?php /** @noinspection PhpUndefinedClassInspection */

namespace App\Telegram;

use DefStudio\Telegraph\Handlers\WebhookHandler;

class TelegramWebHookHandler extends WebhookHandler
{
    public function start(): void
    {
        Log::info("here");
    }

    protected function onFailure(Throwable $throwable): void
    {
        if ($throwable instanceof NotFoundHttpException) {
            throw $throwable;
        }

        report($throwable);

        $this->reply('sorry man, I failed');
    }
}
