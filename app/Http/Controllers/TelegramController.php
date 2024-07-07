<?php

namespace App\Http\Controllers;

use App\Models\ActiveSessionQuestions;
use App\Models\Questions;
use App\Models\TelegramGroupSession;
use App\Models\TriviaEntry;
use DefStudio\Telegraph\Concerns\HasStorage;
use DefStudio\Telegraph\Keyboard\Button;
use DefStudio\Telegraph\Keyboard\Keyboard;
use DefStudio\Telegraph\Models\TelegraphChat;
use Illuminate\Support\Facades\DB;

/**
 * @method groupSession()
 */
class TelegramController extends Controller
{
    use HasStorage;

    public TelegraphChat $chat;
    public TelegramGroupSession $groupSession;
    public ActiveSessionQuestions $question;

    public function __construct()
    {
        $this->chat = TelegraphChat::where('name', '[supergroup] Shikisha Kakitu')->first();
        $this->groupSession = $this->setGroupSession();
        $this->question = $this->setActiveQuestion();
    }

    public function __invoke(): void
    {
        $resp = $this->send_question();
        $this->question->msg_id = $resp->telegraphMessageId();
        $this->question->save();

        $this->update_session();
        sleep(5);
    }

    public function keyboardBuilder($question): Keyboard
    {
        return Keyboard::make()
            ->row([Button::make("$question->Choice_1")->action('ans_question')->param('ans', 'Choice_1')])
            ->row([Button::make("$question->Choice_2")->action('ans_question')->param('ans', 'Choice_2')])
            ->row([Button::make("$question->Choice_3")->action('ans_question')->param('ans', 'Choice_3')])
            ->row([Button::make("$question->Choice_4")->action('ans_question')->param('ans', 'Choice_4')]);
    }

    public function send_question()
    {
        $question = Questions::find($this->question->question_id);
        $this->clear_questions();

        return $this->chat
            ->message($question->question)
            ->keyboard($this->keyboardBuilder($question))->send();
    }

    public function clear_questions()
    {
        $sent_questions = ActiveSessionQuestions::where('msg_id', '<>', null)->get();
        if ($sent_questions->count() > 0) {
            foreach ($sent_questions as $sent_question) {
                $this->chat->deleteKeyboard($sent_question->msg_id)->send();
                $this->chat->deleteMessage($sent_question->msg_id)->send();
            }
        }
    }

    public function update_session(): void
    {
        $stats = json_decode($this->groupSession->stats);
        $current = $stats->timer;
        $set = $current - 1;

        if ($set <= 0)
            $stats->timer = 7;
        else
            $stats->timer = $set;

        $this->groupSession->stats = json_encode($stats);
        $this->groupSession->save();
    }

    public function setGroupSession()
    {
        $group_session = TelegramGroupSession::where('Active', true)->first();

        if (is_null($group_session)) {
            $group_session = TelegramGroupSession::create([
                'timestamp' => time(),
                'active' => true,
                'stats' => json_encode([
                    'timer' => 7,
                    'msg_id' => null,
                    'question_id' => null
                ])
            ]);
        }

        return $group_session;
    }

    public function preLoadQuestions(): void
    {
        $questions = Questions::inRandomOrder()->limit(200)->get();

        foreach ($questions as $question) {
            ActiveSessionQuestions::create([
                'question_id' => $question->id,
                'telegram_group_session_id' => $this->groupSession->id
            ]);
        }
    }

    public function setActiveQuestion()
    {
        $all_active_questions = ActiveSessionQuestions::all();

        if ($all_active_questions->count() == 0) {
            $this->preLoadQuestions();
        }

        $active_question = ActiveSessionQuestions::where('telegram_group_session_id', $this->groupSession->id)
            ->where('msg_id', null)
            ->first();

        if (is_null($active_question) && (ActiveSessionQuestions::all())->count() > 0) {
            $this->closeSession();

            $active_question = ActiveSessionQuestions::where('telegram_group_session_id', $this->groupSession->id)
                ->where('msg_id', null)
                ->first();
        }

        $active_question->time_sent = time();
        $active_question->save();

        return $active_question;
    }

    public function closeSession(): void
    {
        $this->tally();
        $this->clear_questions();
        DB::statement('TRUNCATE TABLE active_session_questions');
        $this->groupSession->Active = false;
        $this->groupSession->running_time = time();
        $this->groupSession->save();
        $this->groupSession = $this->setGroupSession();
        $this->preLoadQuestions();
        $resp = $this->chat->message("New Session Starting in 2 min....")->send();
        $text_id = $resp->telegraphMessageId();
//        sleep(10);
        $this->chat->deleteMessage($text_id)->send();

    }

    public function tally()
    {
        dump(TriviaEntry::all());
    }
}
