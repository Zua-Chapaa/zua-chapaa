<?php

namespace App\Http\Controllers;

use App\Models\ActiveSessionQuestions;
use App\Models\Questions;
use App\Models\TelegramGroupSession;
use DefStudio\Telegraph\Concerns\HasStorage;
use DefStudio\Telegraph\Models\TelegraphChat;
use Illuminate\Support\Facades\DB;

/**
 * @method groupSession()
 */
class TelegramController extends Controller
{
    use HasStorage;

    public $chat;
    public TelegramGroupSession $groupSession;
    public ActiveSessionQuestions|null $question;

    public function __construct()
    {
    }

    public function __invoke(): void
    {
        $this->chat = TelegraphChat::where('name', '[supergroup] Shikisha Kakitu')->first();

        $this->setGroupSession();

        $this->question = ActiveSessionQuestions::where('telegram_group_session_id', $this->groupSession->id)->where('msg_id', null)->first();

        if ($this->question == null) {
            $this->closeSession();
        } else {
            $this->clear_questions();
            $this->send_question();
            return;
        }

    }

    public function setGroupSession($callback = null)
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
    }

    public function send_question()
    {
        $counter = 0;
        $counter_id = null;

        $question = Questions::find($this->question->question_id);
        $question_string = $question->question . "\n\n 🕰 7 seconds";
        $answer = $question->Answer;

        $build = $this->chat->quiz($question_string)
            ->option($question->Choice_1, correct: $answer == 'Choice_1')
            ->option($question->Choice_2, correct: $answer == 'Choice_2')
            ->option($question->Choice_3, correct: $answer == 'Choice_3')
            ->option($question->Choice_4, correct: $answer == 'Choice_4')
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
        $questions = Questions::inRandomOrder()->limit(40)->get();

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
        $results = $this->getWinner($this->groupSession->id);
        $resp = $this->chat->message($results['text'])->send();

        $this->groupSession->Active = false;
        $this->groupSession->running_time = time();
        $this->groupSession->save();

        $text_id = $resp->telegraphMessageId();
        sleep(60);


        DB::statement('TRUNCATE TABLE active_session_questions');
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

    private function getWinner($sessionId)
    {
        $results = DB::select("SELECT
                                        answer_user_id,
                                        telegraph_chats.name,
                                        SUM(is_user_correct + 0) AS total_correct,
                                        AVG(time_to_answer) AS average_timestamp
                                    FROM
                                        trivia_entries
                                    JOIN
                                        telegraph_chats ON telegraph_chats.chat_id = trivia_entries.answer_user_id
                                    WHERE
                                        session_id = ?
                                    GROUP BY
                                        answer_user_id, telegraph_chats.name
                                    ORDER BY
                                        total_correct DESC, average_timestamp
                                ", [$sessionId]);

        $user_name = str_replace("[private] ", "", $results[0]->name);
        $score = $results[0]->total_correct;

        $text =
            "@" . $user_name . ".\n\n Configurations! 🎉. You win this sessionn" .
            "\n You Score : " . $score;


        return [
            'text' => $text,
            'results' => $results
        ];
    }


}
