<?php /** @noinspection PhpUndefinedClassInspection */

namespace App\Telegram;

use App\Http\Controllers\MpesaController;
use App\Telegram\CallBacks\GetChat;
use App\Telegram\CallBacks\HandleChatMessage;
use App\Telegram\CallBacks\Home\Home;
use App\Telegram\CallBacks\Start;
use App\Telegram\CallBacks\TelegramHandler;
use DefStudio\Telegraph\Handlers\WebhookHandler;
use DefStudio\Telegraph\Models\TelegraphBot;
use DefStudio\Telegraph\Models\TelegraphChat;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


class TelegramWebHookHandler extends WebhookHandler
{
    use Start;
    use HandleChatMessage;
    use message;
    use GetChat;

    //Home
    use Home;

    protected array $routes;

    public function __construct(MpesaController $m_pesa_controller)
    {
        parent::__construct();
        $this->setMpesaController($m_pesa_controller);
        $this->routes = $this->getMenu();
    }

    public function handle(Request $request, TelegraphBot $bot): void
    {
        $chat = null;
        $name_has_private = false;

        if ($request->has('message')) {
            $chat_id = $request->get('message')['from']['id'];
            $chat = TelegraphChat::where('chat_id', $chat_id)->first();
            $name_has_private = str_contains($chat->name, 'private');
        }

        if ($name_has_private) {
            if (collect($request['message'])->has('text')) {
                parent::handle($request, $bot);
            } else {
                $chat->message("could not get text")->send();
            }
        } else {
            parent::handle($request, $bot);
        }

    }

    public function handleChatMessage($text = null): void
    {
        $application_context = $this->getChat()->storage()->get('application_context');

        if ($application_context == null) {
            $this->getChat()->storage()->set('application_context', 'Home');
        }

        switch ($application_context) {
            case 'Home':
                $this->goToHome($text);
                break;
            default:
                $this->getChat()->storage()->set('application_context', 'Home');
                $this->goToHome();
        }

    }

    public function getMenu(): array
    {
        $menuFile = __DIR__ . '/Data/menu.csv';
        $data = [];


        if (($handle = fopen($menuFile, 'r')) !== false) {
            // Get the header row
            $header = fgetcsv($handle, 1000, ',');

            // Loop through each row in the CSV file
            while (($row = fgetcsv($handle, 1000, ',')) !== false) {
                // Combine the header with each row to form an associative array
                $data[] = array_combine($header, $row);
            }

            // Close the file
            fclose($handle);
        }

        return $data;
    }

    protected function onFailure(\Throwable $throwable): void
    {
        if ($throwable instanceof NotFoundHttpException) {
            throw $throwable;
        }

        report($throwable);

        $this->reply('Option not available');
    }
}



