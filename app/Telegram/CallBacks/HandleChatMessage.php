<?php

namespace App\Telegram\CallBacks;

use Illuminate\Support\Facades\Log;

trait HandleChatMessage
{
    public function __construct($text)
    {
        Log::info($text);

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
