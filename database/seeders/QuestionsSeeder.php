<?php

namespace Database\Seeders;

use App\Models\Questions;
use Illuminate\Database\Seeder;

class QuestionsSeeder extends Seeder
{
    protected array $questions;

    public function __construct()
    {
        $this->questions = [
            [
                "question" => "Who was the first president of Kenya?",
                "Choice_1" => "Jommo Kenyatta",
                "Choice_2" => "Mwai Kibaki",
                "Choice_3" => "Uhuru Kenyatta",
                "Choice_4" => "Daniel Arap Moi",
                "Answer" => "Choice_1",
            ],
            [
                "question" => "Which of the following is the capital of Kenya",
                "Choice_1" => "Nairobi",
                "Choice_2" => "Malawi",
                "Choice_3" => "Nakuru",
                "Choice_4" => "Naivasha",
                "Answer" => "Choice_1",
            ]
        ];
    }

    public function run(): void
    {
        foreach ($this->questions as $question) {
            $question_prop = new Questions();

            $question_prop->question = $question['question'];
            $question_prop->Choice_1 = $question['Choice_1'];
            $question_prop->Choice_2 = $question['Choice_2'];
            $question_prop->Choice_3 = $question['Choice_3'];
            $question_prop->Choice_4 = $question['Choice_4'];
            $question_prop->Answer = $question['Answer'];

            $question_prop->save();
        }

    }
}
