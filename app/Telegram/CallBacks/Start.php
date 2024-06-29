<?php

namespace App\Telegram\CallBacks;

use DefStudio\Telegraph\Keyboard\Button;
use DefStudio\Telegraph\Keyboard\Keyboard;
use Illuminate\Support\Facades\Log;

//use DefStudio\Telegraph\Keyboard\ReplyButton;
//use DefStudio\Telegraph\Keyboard\ReplyKeyboard;


trait Start
{
    public function start(): void
    {
        Log::info("here");

//        $this->getChat()->message('Please choose your language')
//            ->keyboard(Keyboard::make()->row([
//                Button::make('English')->action('select_language')->param('lang', 'English'),
//                Button::make('Swahili')->action('select_language')->param('lang', 'Swahili'),
//            ]))->send();
    }

//    public function select_language(): void
//    {
//        //get the language chosen
//        $lang = $this->data->get('lang');
//
//        $this
//            ?->getChat()
//            ->message("You have selected $lang")
//            ->replyKeyboard(
//                ReplyKeyboard::make()->buttons([
//                    ReplyButton::make('Home'),
//                    ReplyButton::make('About'),
//                    ReplyButton::make('Balance')->webApp('https://tipsmoto.co.ke'),
//                    ReplyButton::make('Account')->webApp('https://tipsmoto.co.ke'),
//                    ReplyButton::make('FAQ')->webApp('https://tipsmoto.co.ke'),
//                    ReplyButton::make('Leaders Board')->webApp('https://tipsmoto.co.ke'),
//                ])
//            )->send();
//    }
}
