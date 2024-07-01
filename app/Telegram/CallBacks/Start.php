<?php

namespace App\Telegram\CallBacks;

use DefStudio\Telegraph\Concerns\HasStorage;
use DefStudio\Telegraph\Keyboard\Button;
use DefStudio\Telegraph\Keyboard\Keyboard;
use DefStudio\Telegraph\Keyboard\ReplyButton;
use DefStudio\Telegraph\Keyboard\ReplyKeyboard;


trait Start
{
    use GetChat;
    use HasStorage;

    public function start(): void
    {
        $this->getChat()->storage()->set('user_context', "");
        $this->getChat()->message('Please choose your language')
            ->keyboard(Keyboard::make()->row([
                Button::make('English')->action('select_language')->param('lang', 'English'),
                Button::make('Swahili')->action('select_language')->param('lang', 'Swahili'),
            ]))->send();
    }

    public function select_language(): void
    {
        //get the language chosen
        $lang = $this->data->get('lang');

        $this->getChat()->storage()->set('language', $lang);

        $build = $this?->getChat()
            ->message("You have selected $lang")
            ->replyKeyboard(
                ReplyKeyboard::make()->buttons([
                    ReplyButton::make('Home'),
                    ReplyButton::make('Account')->webApp('https://tipsmoto.co.ke'),
                    ReplyButton::make('Balance')->webApp('https://tipsmoto.co.ke'),
                    ReplyButton::make('About'),
                    ReplyButton::make('FAQ')->webApp('https://tipsmoto.co.ke'),
                    ReplyButton::make('Leaders Board')->webApp('https://tipsmoto.co.ke'),
                ])
            );
        $build->send();
    }

}
