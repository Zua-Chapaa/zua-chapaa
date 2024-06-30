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
        $build = $this?->getChat()
            ->message("You have selected $lang");

        $contact_details = $this->is_contact_available();

        $build->send();
    }

    public function is_contact_available(): bool
    {
        Log::info($this->getChat());
        return false;
    }

}
