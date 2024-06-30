<?php

namespace App\Telegram\CallBacks;

use DefStudio\Telegraph\Keyboard\Button;
use DefStudio\Telegraph\Keyboard\Keyboard;
use Illuminate\Support\Facades\Log;


trait Start
{
    use GetChat;

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
        //get the language chosen
        $lang = $this->data->get('lang');

        $build = $this?->getChat()->message($this->build_chat($lang));

        if ($this->is_contact_available()) {
            Log::info("contact exist");
        } else {
            $build->keyboard(Keyboard::make()->row([
                Button::make('Share Contact Information')->action('share_language')
            ]));
        }

        $build->send();

    }


    public function share_language(): void
    {
        Log::info("getting info");
    }

    public function build_chat($lang): string
    {
        $string_one = "You have selected $lang";
        $string_two = "Please share your contact information to complete registration.";

        if ($this->is_contact_available()) {
            return $string_one;
        } else {
            return $string_one . "\n" . "\n" . $string_two;
        }
    }

    public function is_contact_available(): bool
    {
        return false;
    }

}
