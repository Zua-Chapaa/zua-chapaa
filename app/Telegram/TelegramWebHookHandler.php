<?php /** @noinspection PhpUndefinedClassInspection */

namespace App\Telegram;

use App\Telegram\CallBacks\HandleChatMessage;
use App\Telegram\CallBacks\Home\Home;
use App\Telegram\CallBacks\Start;
use App\Telegram\CallBacks\TelegramHandler;
use Illuminate\Support\Stringable;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


class TelegramWebHookHandler extends \DefStudio\Telegraph\Handlers\WebhookHandler
{
    use Start;
    use HandleChatMessage;

    //Home
    use Home;

    protected array $routes;

    public function __construct()
    {
        parent::__construct();

        $this->routes = [
            "home" => ['fun' => 'goToHome'],
            "Account" => ['fun' => 'viewAccount'],
            "Balance" => ['fun' => 'checkBalance'],
            "Leaders Board" => ['fun' => 'goToLeadersBoard'],
            "About" => ['fun' => 'goToAbout'],
            "FAQ" => ['fun' => 'viewFAQ'],
        ];
    }

    /**
     * @throws \Throwable
     */
    public function handleChatMessage(Stringable $text): void
    {
        $chat = $this->getChat()->message("here");

//
//        foreach ($this->routes as $key => $route) {
//            if (strcasecmp($key, $text) === 0) {
//                $function = $route['fun'];
//                if (method_exists($this, $function)) {
//                    $this->$function($text);
//                    return;
//                }
//            }
//        }
    }

    /**
     * @throws \Throwable
     */
    protected function onFailure(\Throwable $throwable): void
    {
        if ($throwable instanceof NotFoundHttpException) {
            throw $throwable;
        }

        report($throwable);

        $this->reply('Option not available');
    }
}


