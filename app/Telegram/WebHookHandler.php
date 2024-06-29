<?php

namespace App\Telegram;

use App\Telegram\CallBacks\Handler;
use App\Telegram\CallBacks\Start;
use DefStudio\Telegraph\Keyboard\ReplyButton;
use DefStudio\Telegraph\Keyboard\ReplyKeyboard;
use PHPUnit\Event\Code\Throwable;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use App\Telegram\CallBacks\HandleChatMessage;

class WebHookHandler extends \DefStudio\Telegraph\Handlers\WebhookHandler
{
    use HandleChatMessage;
    use Start;
    use Handler;

    public function select_language(): void
    {
        //get the language chosen
        $lang = $this->data->get('lang');

        $this
            ?->getChat()
            ->message("You have selected $lang")
            ->replyKeyboard(
                ReplyKeyboard::make()->buttons([
                    ReplyButton::make('Home'),
                    ReplyButton::make('About'),
                    ReplyButton::make('Balance'),
                    ReplyButton::make('Account'),
                    ReplyButton::make('FAQ'),
                    ReplyButton::make('Leaders Board')->webApp('https://tipsmoto.co.ke'),
                ])
            )->send();
    }


    // errors
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
