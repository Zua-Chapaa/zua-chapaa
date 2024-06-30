<?php /** @noinspection PhpUndefinedClassInspection */

namespace App\Telegram;

use Illuminate\Support\Facades\Log;
use Throwable;

class TelegramWebHookHandler extends \DefStudio\Telegraph\Handlers\WebhookHandler
{
    public function start():void
    {
        Log::info("here");
    }

    /**
     * @throws Throwable
     */
    protected function onFailure(Throwable $throwable): void
    {
        if ($throwable instanceof \Symfony\Component\HttpKernel\Exception\NotFoundHttpException) {
            throw $throwable;
        }

        report($throwable);

        $this->reply('sorry man, I failed');
    }
}


