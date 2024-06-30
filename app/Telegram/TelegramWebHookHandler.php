<?php /** @noinspection PhpUndefinedClassInspection */

namespace App\Telegram;

class TelegramWebHookHandler extends \DefStudio\Telegraph\Handlers\WebhookHandler
{
    protected function onFailure(\Throwable $throwable): void
    {
        if ($throwable instanceof \Symfony\Component\HttpKernel\Exception\NotFoundHttpException) {
            throw $throwable;
        }

        report($throwable);

        $this->reply('sorry man, I failed');
    }
}


