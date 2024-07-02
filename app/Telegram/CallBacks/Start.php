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


    public function start_setup(): void
    {
        $this->getChat()->storage()->set('user_context', "");
        $this->getChat()->storage()->set('plan', "");
    }

    public function start(): void
    {
        $telegram_id = $this->getChat()->id;

        $user_generated = $this->bindUser($telegram_id);

        if ($user_generated) {
            $this->start_setup();

            $this->getChat()->message('Please choose your language')
                ->keyboard(Keyboard::make()->row([
                    Button::make('English')->action('select_language')->param('lang', 'English'),
                    Button::make('Swahili')->action('select_language')->param('lang', 'Swahili'),
                ]))->send();
        }

    }

    public function bindUser($telegram_id): int
    {
        $users = User::where('telegram_id', $telegram_id)->get();

        $this->msg("here");

        return 0;

        if (count($users->collect()) > 0) {
            $this->msg("exist");
        } else {
            $user = new User();


            $user->name = $this->getChat()->name;
            $user->telegram_id = $telegram_id;

            $this->msg($user->save());
        }
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
