<?php /** @noinspection PhpUndefinedClassInspection */

namespace App\Telegram;

use App\Telegram\CallBacks\Start;
use App\Telegram\CallBacks\TelegramHandler;
use PHPUnit\Event\Code\Throwable;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use App\Telegram\CallBacks\HandleChatMessage;
use App\Telegram\CallBacks\TelegramHandler;

class WebHookHandler extends \DefStudio\Telegraph\Handlers\WebhookHandler
{
    use HandleChatMessage;
    use Start;
    use TelegramHandler;



    /**
     * @throws \Throwable
     */
    protected function onFailure(Throwable|\Throwable $throwable): void
    {
        if ($throwable instanceof NotFoundHttpException) {
            throw $throwable;
        }

        report($throwable);
        $this->reply('Failed...');
    }
}
