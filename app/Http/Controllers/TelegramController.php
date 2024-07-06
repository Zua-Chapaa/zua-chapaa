<?php

namespace App\Http\Controllers;

use App\Models\ActiveSessionQuestions;
use App\Models\Questions;
use App\Models\TelegramGroupSession;
use DefStudio\Telegraph\Keyboard\Button;
use DefStudio\Telegraph\Keyboard\Keyboard;
use DefStudio\Telegraph\Models\TelegraphChat;
use Illuminate\Support\Facades\DB;

class TelegramController extends Controller
{
    public function __invoke(): void
    {
        $madeline = $this->import_madeline();
        $chat = TelegraphChat::where('name', '[supergroup] Shikisha Kakitu')->first();
        $active_session = $this->active_session();
        $active_questions = $this->active_question($active_session);

        if ($active_questions != null) {

            $question = Questions::find($active_questions->id);

            $msg = $chat->message($question->question)
                ->keyboard(Keyboard::make()
                    ->row([Button::make("$question->Choice_1")->action('')->param('plan', 'hourly')])
                    ->row([Button::make("$question->Choice_2")->action('select_plan')->param('plan', 'hourly')])
                    ->row([Button::make("$question->Choice_3")->action('select_plan')->param('plan', 'hourly')])
                    ->row([Button::make("$question->Choice_4")->action('select_plan')->param('plan', 'hourly')])
                )
                ->send();

            dd($msg);

        } else {
            $active_session->Active = 0;
            $active_session->running_time = time();
            $active_session->save();

            // Truncate the table active_session_questions
            DB::statement('TRUNCATE TABLE active_session_questions');
        }
    }

    private function active_session()
    {
        $active_telegram_group_session = TelegramGroupSession::where('Active', true)->first();

        if ($active_telegram_group_session == null || ($active_telegram_group_session->count() == 0)) {
            $group_session = new TelegramGroupSession();

            $group_session->timestamp = time();
            $group_session->active = true;

            $group_session->save();

            return $group_session;
        } else {
            return $active_telegram_group_session;
        }
    }

    private function active_question(TelegramGroupSession $active_session)
    {

        $active_questions = ActiveSessionQuestions::all();

        if ($active_questions->count() <= 0) {
            $questions = Questions::inRandomOrder()->limit(200)->get();

            foreach ($questions as $question) {
                $active_question_temp = new ActiveSessionQuestions();

                $active_question_temp->question_id = $question->id;
                $active_question_temp->telegram_group_session_id = $active_session->id;

                $active_question_temp->save();
            }
        }

        $active_question = ActiveSessionQuestions::where('telegram_group_session_id', $active_session->id)->where('sent', false)->first();

        if ($active_question != null) {
            $active_question->sent = true;
            $active_question->save();
            return $active_question;
        } else {
            return null;
        }
    }

    public function import_madeline(): true
    {
        dd(PHP_INT_SIZE * 8 . " bit");

        if (!file_exists('madeline.php')) {
            copy('https://phar.madelineproto.xyz/madeline.php', 'madeline.php');
        }

        include 'madeline.php';
        return true;
    }

}
