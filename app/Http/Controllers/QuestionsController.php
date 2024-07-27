<?php

namespace App\Http\Controllers;

use App\Models\Questions;
use Inertia\Inertia;

class QuestionsController extends Controller
{
    public function set_questions()
    {
//        // Select questions randomly and limit to 200
//        $questions = Questions::inRandomOrder()->limit(200)->get();
//
//        foreach ($questions as $question) {
//            $active_question =
//        }
    }

    public function List_Questions()
    {
        $questions = Questions::all();

        $questions->transform(function ($question) {
            dd($questions);

            return $question;
        });

        return Inertia::render('Application/Questions/index', [
            'questions' => $questions
        ]);
    }

}
