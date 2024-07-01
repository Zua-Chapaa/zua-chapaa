<?php

namespace App\Telegram\CallBacks;

use App\Telegram\CallBacks\Home\Home;
use DefStudio\Telegraph\Keyboard\Button;
use DefStudio\Telegraph\Keyboard\Keyboard;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Stringable;

trait HandleChatMessage
{
    use GetChat;
    use Home;


    public function handleChatMessage(Stringable $text): void
    {
        $chat = $this->getChat()->message($text);

        switch ($text) {
            case 'Home':
                $this->goToHome($text);
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
                break;
        }
    }

    private function goToHome($text = null): void
    {
        if (
            !empty($this->getChat()->storage()->get('user_context')) &&
            $this->getChat()->storage()->get('user_context') == 'phone_number_request_mode'
        ) {
            Log::info("here");

            if (!$this->validateNumber($text)) {

                //reset context
                $this->getChat()->storage()->set('user_context', "");

                //Advice user on corrections
                $this?->getChat()
                    ->message(
                        "The number you entered was invalid use either \n
                        07********
                        +2547********
                        2547********
                        Formats
                        ")
                    ->keyboard(Keyboard::make()->row([
                        Button::make('Try Again')
                            ->action('invalid_phone_number_action')
                            ->param('action', 'Try Again'),

                        Button::make('Cancel')
                            ->action('invalid_phone_number_action')
                            ->param('action', 'Cancel'),
                    ]))->send();
            }else{
//make a payment request
                $this->getChat()->message("Please accept the payment request made to continue.");
            }
        }else{
            //application not in subscription mode

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
//        $this->goToHome();
    }


}
