<?php

namespace App\Telegram\CallBacks;

use DefStudio\Telegraph\Keyboard\Button;
use DefStudio\Telegraph\Keyboard\Keyboard;
use Illuminate\Support\Stringable;

trait HandleChatMessage
{
    use GetChat;

    public function handleChatMessage(Stringable $text): void
    {
        $chat = $this->getChat()->message("here");

        switch ($text) {
            case 'Home':
                $this->goToHome();
                break;
            case 'Account':
                $this->viewAccount();
                break;
            case 'Balance':
                $this->checkBalance();
                break;
            case 'Leaders Board':
                $this->goToLeadersBoard();
                break;
            case 'About':
                $this->goToAbout();
                break;
            case 'FAQ':
                $this->viewFAQ();
                break;
            default:
                $this->defaultResponse();
                break;
        }
    }

    private function goToHome(): void
    {
        $this->getChat()->message('Select a plan to proceed')
            ->keyboard(Keyboard::make()->row([
                Button::make('Hourly Plan @Ksh 100')
                    ->action('select_plan')
                    ->param('plan', 'hourly'),

                Button::make('Day Plan @Ksh 1500')
                    ->action('select_plan')
                    ->param('plan', 'daily'),
            ]))->send();
    }

    private function goToLeadersBoard()
    {

    }

    private function goToAbout()
    {

    }

    private function checkBalance()
    {

    }

    private function viewAccount()
    {

    }

    private function viewFAQ()
    {

    }

    private function defaultResponse(): void
    {
        $this->goToHome();
    }


}
