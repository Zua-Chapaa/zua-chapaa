<?php /** @noinspection PhpUndefinedClassInspection */

namespace App\Telegram;

use App\Telegram\CallBacks\HandleChatMessage;
use App\Telegram\CallBacks\Home\Home;
use App\Telegram\CallBacks\Start;
use App\Telegram\CallBacks\TelegramHandler;


class TelegramWebHookHandler extends \DefStudio\Telegraph\Handlers\WebhookHandler
{
    use Start;
    use HandleChatMessage;
    use TelegramHandler;


    use Home;
}


