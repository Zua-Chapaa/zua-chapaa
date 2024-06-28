<?php

namespace App\Telegram;

use DefStudio\Telegraph\Keyboard\Button;
use DefStudio\Telegraph\Keyboard\Keyboard;
use DefStudio\Telegraph\Keyboard\ReplyButton;
use DefStudio\Telegraph\Keyboard\ReplyKeyboard;
use DefStudio\Telegraph\Models\TelegraphChat;
use Illuminate\Support\Facades\Log;
use PHPUnit\Event\Code\Throwable;
use Stringable;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class WebHookHandler extends \DefStudio\Telegraph\Handlers\WebhookHandler
{
    public function start(): void
    {
        $chat = $this->getChat();
        $chat
            ->message('Please choose your language')
            ->keyboard(Keyboard::make()->row([
                Button::make('English')->action('select_language')->param('lang', 'English'),
                Button::make('Swahili')->action('select_language')->param('lang', 'Swahili'),
            ]))->send();
    }

    public function handleChatMessage($text): void
    {
        $chat = $this->getChat();

        $chat->message($text)->send();
    }


    public function goToLeadersBoard(){

    }

    public function select_language(): void
    {
        //get the language chosen
        $lang = $this->data->get('lang');

        $this
            ->getChat()
            ->message("You have selected $lang")
            ->replyKeyboard(
                ReplyKeyboard::make()->buttons([
                    ReplyButton::make('Home'),
                    ReplyButton::make('About'),
                    ReplyButton::make('Balance'),
                    ReplyButton::make('Account'),
                    ReplyButton::make('FAQ'),
                    ReplyButton::make('Leaders Board') ->webApp('https://tipsmoto.co.ke'),
                ])
            )->send();
    }

    public function goToHome(): void
    {
        $chat = $this->getChat();

        $chat->message('Select a plan to proceed')
            ->keyboard(Keyboard::make()->row([
                Button::make('Hourly Plan @Ksh 100')->action('select_plan')->param('plan', 'hourly'),
                Button::make('Day Plan @Ksh 1500')->action('select_plan')->param('plan', 'daily'),
            ]))->send();
    }

    public function goToAbout()
    {

    }

    public function checkBalance()
    {
    }


    public function viewAccount()
    {

    }

    public function viewFAQ()
    {

    }

    public function defaultResponse()
    {

    }


    public function switchContext()
    {

    }


    //helpers
    private function getChat()
    {
        return TelegraphChat::where('chat_id', $this->chat->chat_id)->first();
    }



    //errors

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
