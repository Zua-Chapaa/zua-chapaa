<?php

namespace App\Telegram\CallBacks;

use DefStudio\Telegraph\Keyboard\Button;
use DefStudio\Telegraph\Keyboard\Keyboard;
use Illuminate\Support\Facades\Log;

trait HandleChatMessage
{
    public function __construct($text)
    {
        $chat = $this->getChat();


        $chat->message($text);


        switch ($text) {
            case 'Home':
                $this->goToHome();
                break;
            case 'Leaders Board':
                $this->goToLeadersBoard();
                break;
            case 'About':
                $this->goToAbout();
                break;
            case 'Balance':
                $this->checkBalance();
                break;
            case 'Account':
                $this->viewAccount();
                break;
            case 'FAQ':
                $this->viewFAQ();
                break;
            default:
                $this->defaultResponse();
                break;
        }
    }

    private function goToHome()
    {
        $this->getChat()->message('Select a plan to proceed')
            ->keyboard(Keyboard::make()->row([
                Button::make('Hourly Plan @Ksh 100')->action('select_plan')->param('plan', 'hourly'),
                Button::make('Day Plan @Ksh 1500')->action('select_plan')->param('plan', 'daily'),
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

    private function defaultResponse()
    {
    }


}
