<?php /** @noinspection PhpUndefinedClassInspection */

namespace App\Telegram;

//{
//    public function start(): void
//    {
//        Log::info("here");
//    }
//
//    protected function onFailure(Throwable $throwable): void
//    {
//        if ($throwable instanceof NotFoundHttpException) {
//            throw $throwable;
//        }
//
//        report($throwable);
//
//        $this->reply('sorry man, I failed');
//    }
//}

class TelegramWebHookHandler extends \DefStudio\Telegraph\Handlers\WebhookHandler
{
    protected function onFailure(Throwable $throwable): void
    {
        if ($throwable instanceof NotFoundHttpException) {
            throw $throwable;
        }

        report($throwable);

        $this->reply('sorry man, I failed');
    }
}

