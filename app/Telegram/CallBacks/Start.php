<?php

namespace App\Telegram\CallBacks;

use App\Models\User;
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
        $telegram_id = $this->getChat()->id;
        $user_generated = $this->bindUser($telegram_id);
        $name_has_private = str_contains($this->getChat()->name, 'private');

        if ($name_has_private && $user_generated) {
            $this->start_setup();

            $this->getChat()->message('Please choose your language')
                ->keyboard(Keyboard::make()
                    ->row([
                        Button::make('English')->action('select_language')->param('lang', 'English'),
                        Button::make('Swahili')->action('select_language')->param('lang', 'Swahili'),
                    ])
                )->send();
        } else {
            $this->getChat()->message('Please choose your language')
                ->keyboard(Keyboard::make()
                    ->row([
                        Button::make('English')->action('select_language')->param('lang', 'English'),
                        Button::make('Swahili')->action('select_language')->param('lang', 'Swahili'),
                    ])
                )->send();
        }
    }

    public function bindUser($telegram_id)
    {
        $user = User::where('telegram_id', $telegram_id)->get();

        if (count($user->collect()) > 0) {
            //user exist
            return $user[0];
        } else {
            //user does not exist
            //create a new user
            $user = new User();
            $user->name = $this->getChat()->name;
            $user->telegram_id = $telegram_id;
            $user->save();

            return $user;
        }
    }

    public function select_language(): void
    {
        //set the language
        $this->getChat()->storage()->set('language', $this->data->get('lang'));

        //display the menu
        $this->getChat()
            //display the language selected
            ->message("You have selected" . $this->data->get('lang'))

            //display the language
            ->replyKeyboard(
                ReplyKeyboard::make()->buttons([
                    ReplyButton::make('Home'),
                    ReplyButton::make('Account')->webApp("https://zuachapaa.tipsmoto.co.ke/account/" . $this->getChat()->id),
                    ReplyButton::make('Balance')->webApp('https://zuachapaa.tipsmoto.co.ke/balance/' . $this->getChat()->id),
                    ReplyButton::make('Leaders Board')->webApp("https://zuachapaa.tipsmoto.co.ke/leaderboard"),
                    ReplyButton::make('About')->webApp('https://zuachapaa.tipsmoto.co.ke/about/'),
                    ReplyButton::make('FAQ')->webApp('https://zuachapaa.tipsmoto.co.ke/faq'),
                ])
            )

            //send response
            ->send();
    }

    //private functions
    private function start_setup(): void
    {
        $this->getChat()->storage()->set('application_context', "");
        $this->getChat()->storage()->set('user_context', "");
        $this->getChat()->storage()->set('language', "");
        $this->getChat()->storage()->set('plan', "");
    }

}
