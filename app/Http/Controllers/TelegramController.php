<?php

namespace App\Http\Controllers;

use App\Models\ActiveSessionQuestions;
use App\Models\Questions;
use App\Models\TelegramGroupSession;
use DefStudio\Telegraph\Concerns\HasStorage;
use DefStudio\Telegraph\Models\TelegraphChat;
use Illuminate\Support\Facades\DB;
use JetBrains\PhpStorm\NoReturn;

/**
 * @method groupSession()
 */
class TelegramController extends Controller
{
    use HasStorage;

    public $chat;
    public TelegramGroupSession $groupSession;
    public ActiveSessionQuestions|null $question;

    #[NoReturn] public function __construct()
    {
    }

    public function __invoke(): void
    {
        $this->chat = TelegraphChat::where('name', '[supergroup] Shikisha Kakitu')->first();
        $this->setGroupSession();

        $this->question = ActiveSessionQuestions::where('telegram_group_session_id', $this->groupSession->id)
            ->where('msg_id', null)
            ->first();

        if ($this->question == null) {
            $this->closeSession();
            dd("done");
        } else {
            $this->send_question();
            return;
        }

    }

    #[NoReturn] public function setGroupSession($callback = null)
    {
        $group_session = TelegramGroupSession::where('Active', true)->first();

        if (is_null($group_session)) {
            $group_session = TelegramGroupSession::create([
                'timestamp' => time(),
                'active' => true,
                'stats' => json_encode([
                    'timer' => 1,
                    'msg_id' => null,
                    'question_id' => null
                ])
            ]);

            $this->groupSession = $group_session;

            DB::statement('TRUNCATE TABLE active_session_questions');

            $this->preLoadQuestions();

        } else {
            $this->groupSession = $group_session;
        }

//        dump($this->groupSession->id);
//        $questions = ActiveSessionQuestions::all();
//        foreach ($questions as $question) {
//            dump($question->attributesToArray());
//        }
    }

    public function send_question()
    {
        $counter = 0;
        $counter_id = null;

        $question = Questions::find($this->question->question_id);
        $question_string = $question->question . "\n\n 🕰 7 seconds";


        $build = $this->chat->quiz($question_string)
            ->option($question->Choice_1, correct: true)
            ->option($question->Choice_2)
            ->option($question->Choice_3)
            ->option($question->Choice_4)
            ->validUntil(now()->addSecond(7))
            ->disableAnonymous()
            ->send();

        $message_id = $build->telegraphMessageId();
        $this->question->msg_id = $message_id;
        $this->question->save();

        sleep(7);
    }

    public function preLoadQuestions(): void
    {
        $questions = Questions::inRandomOrder()->limit(5)->get();

        foreach ($questions as $question) {
            ActiveSessionQuestions::create([
                'question_id' => $question->id,
                'telegram_group_session_id' => $this->groupSession->id
            ]);
        }
    }

    public function closeSession(): void
    {
        $this->clear_questions();
        $resp = $this->chat->message("Posting results")->send();
        DB::statement('TRUNCATE TABLE active_session_questions');

        $this->groupSession->Active = false;
        $this->groupSession->running_time = time();
        $this->groupSession->save();

        $text_id = $resp->telegraphMessageId();
        sleep(15);
        $this->chat->deleteMessage($text_id)->send();
    }

    public function clear_questions()
    {
        $sent_questions = ActiveSessionQuestions::where('msg_id', '<>', null)->get();
        if ($sent_questions->count() > 0) {
            foreach ($sent_questions as $sent_question) {
                $this->chat->deleteMessage($sent_question->msg_id)->send();
            }
        }
    }


}
