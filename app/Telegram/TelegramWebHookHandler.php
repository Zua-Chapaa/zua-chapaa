<?php /** @noinspection PhpUndefinedClassInspection */

namespace App\Telegram;

use App\Telegram\CallBacks\Start;
use Throwable;

class TelegramWebHookHandler extends \DefStudio\Telegraph\Handlers\WebhookHandler
{

    use Start;



















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


