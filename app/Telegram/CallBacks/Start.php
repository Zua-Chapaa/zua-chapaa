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


    public function __construct()
    {
        $this->getChat()->storage()->set('user_context', "");
    }

    public function start(): void
    {
        $this->getChat()->message('Please choose your language')
            ->keyboard(Keyboard::make()->row([
                Button::make('English')->action('select_language')->param('lang', 'English'),
                Button::make('Swahili')->action('select_language')->param('lang', 'Swahili'),
            ]))->send();
    }

    public function select_language(): void
    {

        //set the language
        $this->getChat()
            ->storage()
            ->set('language', $this->data->get('lang'));

        //display the menu
        $build = $this->getChat()

            //display the language selected
            ->message("You have selected " . $this->data->get('lang'))

            //display the language
            ->replyKeyboard(
                ReplyKeyboard::make()->buttons([
                    ReplyButton::make('Home'),
                    ReplyButton::make('Account')->webApp('https://tipsmoto.co.ke'),
                    ReplyButton::make('Balance')->webApp('https://tipsmoto.co.ke'),
                    ReplyButton::make('About'),
                    ReplyButton::make('FAQ')->webApp('https://tipsmoto.co.ke'),
                    ReplyButton::make('Leaders Board')->webApp('https://tipsmoto.co.ke'),
                ])
            )

            //send response
            ->send();
    }

}
