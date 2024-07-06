<?php

namespace App\Telegram\CallBacks\Home;

use App\Models\Questions;

trait GroupAnswer
{
    /**
     * @throws \Exception
     */
    public function ans_question(): void
    {
        $user_id = request()['callback_query']['from']['id'];
        $question = request()['callback_query']['message']['text'];
        $answer = $this->extratc_answer();
        $question_id = Questions::where('question', $question)->first()->id;
        $correct_answer = Questions::where('question', $question)->first()->Answer;
        $is_user_correct = $this->is_user_correct($answer, $correct_answer, Questions::where('question', $question)->first());
        $time_to_ans = time();
        $set_ans = match ($correct_answer) {
            'Choice_1' => $question->Choice_1,
            'Choice_2' => $question->Choice_2,
            'Choice_3' => $question->Choice_3,
            'Choice_4' => $question->Choice_4,
            default => throw new \Exception("Error finding answer"),
        };


//            $TriviaEntry->user_id = $user_id;
//            $TriviaEntry->question = $question;
//            $TriviaEntry->answer = $answer;
//            $TriviaEntry->set_ans = $set_ans;
//            $TriviaEntry->is_user_correct = $is_user_correct;
//            $TriviaEntry->time_to_ans = $time_to_ans;
    }

    public function extratc_answer(): string
    {
        $string = request()['callback_query']['data'];

        // Find the position of "ans:"
        $startPos = strpos($string, "ans:");

        if ($startPos !== false) {
            // Extract text after "ans:"
            return substr($string, $startPos + strlen("ans:"));
        } else {
            return "";
        }
    }

    public function is_user_correct(string $answer, $correct_answer, Questions $question): bool
    {

        $set_ans = match ($correct_answer) {
            'Choice_1' => $question->Choice_1,
            'Choice_2' => $question->Choice_2,
            'Choice_3' => $question->Choice_3,
            'Choice_4' => $question->Choice_4,
            default => throw new \Exception("Error finding answer"),
        };

        return $set_ans == $answer;
    }
}
