<?php /** @noinspection PhpUndefinedClassInspection */

namespace App\Telegram;

use DefStudio\Telegraph\Keyboard\Button;
use DefStudio\Telegraph\Keyboard\Keyboard;
use DefStudio\Telegraph\Models\TelegraphChat;
use Illuminate\Support\Facades\Log;
use Throwable;

class TelegramWebHookHandler extends \DefStudio\Telegraph\Handlers\WebhookHandler
{
    public function start():void
    {

        $this->getChat()->message('Please choose your language')
            ->keyboard(Keyboard::make()->row([
                Button::make('English')->action('select_language')->param('lang', 'English'),
                Button::make('Swahili')->action('select_language')->param('lang', 'Swahili'),
            ]))->send();
    }

    //test

    function getChat()
    {
        return TelegraphChat::where('chat_id', $this->chat->chat_id)->first();
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


