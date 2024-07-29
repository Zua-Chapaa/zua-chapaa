<?php /** @noinspection PhpUndefinedClassInspection */

namespace App\Telegram;

use App\Http\Controllers\MpesaController;
use App\Models\Questions;
use App\Models\TelegramGroupSession;
use App\Models\TriviaEntry;
use App\Telegram\CallBacks\GetChat;
use App\Telegram\CallBacks\HandleChatMessage;
use App\Telegram\CallBacks\Home\GroupAnswer;
use App\Telegram\CallBacks\Home\Home;
use App\Telegram\CallBacks\Start;
use App\Telegram\CallBacks\TelegramHandler;
use DefStudio\Telegraph\Handlers\WebhookHandler;
use DefStudio\Telegraph\Models\TelegraphBot;
use DefStudio\Telegraph\Models\TelegraphChat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


class TelegramWebHookHandler extends WebhookHandler
{
    use Start;
    use HandleChatMessage;
    use message;
    use GetChat;
    use GroupAnswer;

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
        $chat_id = $request->has('message') ? $request->get('message')['from']['id'] : null;
        $chat = !is_null($chat_id) ? TelegraphChat::where('chat_id', $chat_id)->first() : null;
        $name_has_private = !is_null($chat) ? str_contains($chat->name, 'private') : null;


        if ($request->has('poll') || $request->has('poll_answer')) {
            $this->handleQuizResponse($request, $bot);
        } else {
            Log::info("passed");
//            parent::handle($request, $bot);
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

    private function handleQuizResponse(Request $request, TelegraphBot $bot)
    {
        if ($request->has('poll')) {
            $trivia_entry = new TriviaEntry();

            $trivia_entry->poll_id = $request->input('poll.id');
            $trivia_entry->question = $request->input('poll.question');

            $ans_id = $request->input('poll.correct_option_id');
            $ans = $request->input('poll.options');

            $trivia_entry->question_answer = $ans[$ans_id]['text'];

            $trivia_entry->session_id = TelegramGroupSession::where('Active', 1)->first()->id;

            $trivia_entry->save();
        } else {
            $trivia_entry = TriviaEntry::where('poll_id', $request->input('poll_answer.poll_id'));
            $trivia_entry_question = Questions::where('');

            $trivia_entry->answer_user_id = $request->input('poll_answer.user.id');
            $trivia_entry->user_answer = $request->input('poll_answer.option_ids');
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



