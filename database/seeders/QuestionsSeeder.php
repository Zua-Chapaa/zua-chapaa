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
                "Choice_1" => "Jomo Kenyatta",
                "Choice_2" => "Mwai Kibaki",
                "Choice_3" => "Uhuru Kenyatta",
                "Choice_4" => "Daniel Arap Moi",
                "Answer" => "Choice_1",
            ],
            [
                "question" => "Which of the following is the capital of Kenya?",
                "Choice_1" => "Nairobi",
                "Choice_2" => "Malawi",
                "Choice_3" => "Nakuru",
                "Choice_4" => "Naivasha",
                "Answer" => "Choice_1",
            ],
            [
                "question" => "What is the capital of France?",
                "Choice_1" => "Berlin",
                "Choice_2" => "Madrid",
                "Choice_3" => "Rome",
                "Choice_4" => "Paris",
                "Answer" => "Choice_4",
            ],
            [
                "question" => "Which planet is known as the Red Planet?",
                "Choice_1" => "Venus",
                "Choice_2" => "Mars",
                "Choice_3" => "Jupiter",
                "Choice_4" => "Saturn",
                "Answer" => "Choice_2",
            ],
            [
                "question" => "What is the largest mammal in the world?",
                "Choice_1" => "Elephant",
                "Choice_2" => "Blue Whale",
                "Choice_3" => "Giraffe",
                "Choice_4" => "Great White Shark",
                "Answer" => "Choice_2",
            ],
            [
                "question" => "How many continents are there on Earth?",
                "Choice_1" => "5",
                "Choice_2" => "6",
                "Choice_3" => "7",
                "Choice_4" => "8",
                "Answer" => "Choice_3",
            ],
            [
                "question" => "Who wrote 'Romeo and Juliet'?",
                "Choice_1" => "Charles Dickens",
                "Choice_2" => "William Shakespeare",
                "Choice_3" => "Mark Twain",
                "Choice_4" => "Jane Austen",
                "Answer" => "Choice_2",
            ],
            [
                "question" => "What is the chemical symbol for water?",
                "Choice_1" => "H2O",
                "Choice_2" => "O2",
                "Choice_3" => "CO2",
                "Choice_4" => "NaCl",
                "Answer" => "Choice_1",
            ],
            [
                "question" => "Which country is known for the maple leaf symbol?",
                "Choice_1" => "USA",
                "Choice_2" => "Canada",
                "Choice_3" => "Australia",
                "Choice_4" => "Brazil",
                "Answer" => "Choice_2",
            ],
            [
                "question" => "What is the smallest prime number?",
                "Choice_1" => "1",
                "Choice_2" => "2",
                "Choice_3" => "3",
                "Choice_4" => "5",
                "Answer" => "Choice_2",
            ],
            [
                "question" => "What is the main ingredient in guacamole?",
                "Choice_1" => "Tomato",
                "Choice_2" => "Avocado",
                "Choice_3" => "Onion",
                "Choice_4" => "Pepper",
                "Answer" => "Choice_2",
            ],
            [
                "question" => "Who painted the Mona Lisa?",
                "Choice_1" => "Vincent van Gogh",
                "Choice_2" => "Pablo Picasso",
                "Choice_3" => "Leonardo da Vinci",
                "Choice_4" => "Claude Monet",
                "Answer" => "Choice_3",
            ],
            [
                "question" => "Which ocean is the largest?",
                "Choice_1" => "Atlantic Ocean",
                "Choice_2" => "Indian Ocean",
                "Choice_3" => "Arctic Ocean",
                "Choice_4" => "Pacific Ocean",
                "Answer" => "Choice_4",
            ],
            [
                "question" => "What is the hardest natural substance on Earth?",
                "Choice_1" => "Gold",
                "Choice_2" => "Iron",
                "Choice_3" => "Diamond",
                "Choice_4" => "Silver",
                "Answer" => "Choice_3",
            ],
            [
                "question" => "Who is known as the 'Father of Computers'?",
                "Choice_1" => "Albert Einstein",
                "Choice_2" => "Isaac Newton",
                "Choice_3" => "Charles Babbage",
                "Choice_4" => "Alexander Graham Bell",
                "Answer" => "Choice_3",
            ],
            [
                "question" => "What is the tallest mountain in the world?",
                "Choice_1" => "K2",
                "Choice_2" => "Kangchenjunga",
                "Choice_3" => "Lhotse",
                "Choice_4" => "Mount Everest",
                "Answer" => "Choice_4",
            ],
            [
                "question" => "What is the largest organ in the human body?",
                "Choice_1" => "Liver",
                "Choice_2" => "Skin",
                "Choice_3" => "Heart",
                "Choice_4" => "Brain",
                "Answer" => "Choice_2",
            ],
            [
                "question" => "Which is the longest river in the world?",
                "Choice_1" => "Amazon River",
                "Choice_2" => "Nile River",
                "Choice_3" => "Yangtze River",
                "Choice_4" => "Mississippi River",
                "Answer" => "Choice_2",
            ],
            [
                "question" => "Who discovered penicillin?",
                "Choice_1" => "Louis Pasteur",
                "Choice_2" => "Alexander Fleming",
                "Choice_3" => "Marie Curie",
                "Choice_4" => "Gregor Mendel",
                "Answer" => "Choice_2",
            ],
            [
                "question" => "Which element is said to keep bones strong?",
                "Choice_1" => "Iron",
                "Choice_2" => "Calcium",
                "Choice_3" => "Potassium",
                "Choice_4" => "Sodium",
                "Answer" => "Choice_2",
            ],
            [
                "question" => "Which planet is closest to the Sun?",
                "Choice_1" => "Venus",
                "Choice_2" => "Earth",
                "Choice_3" => "Mercury",
                "Choice_4" => "Mars",
                "Answer" => "Choice_3",
            ],
            [
                "question" => "Who was the first President of the United States?",
                "Choice_1" => "Thomas Jefferson",
                "Choice_2" => "Benjamin Franklin",
                "Choice_3" => "John Adams",
                "Choice_4" => "George Washington",
                "Answer" => "Choice_4",
            ],
            [
                "question" => "What is the primary language spoken in Brazil?",
                "Choice_1" => "Spanish",
                "Choice_2" => "Portuguese",
                "Choice_3" => "French",
                "Choice_4" => "English",
                "Answer" => "Choice_2",
            ],
            [
                "question" => "What is the currency of Japan?",
                "Choice_1" => "Dollar",
                "Choice_2" => "Yuan",
                "Choice_3" => "Yen",
                "Choice_4" => "Won",
                "Answer" => "Choice_3",
            ],
            [
                "question" => "Which gas do plants absorb from the atmosphere?",
                "Choice_1" => "Oxygen",
                "Choice_2" => "Nitrogen",
                "Choice_3" => "Carbon Dioxide",
                "Choice_4" => "Hydrogen",
                "Answer" => "Choice_3",
            ],
            [
                "question" => "Who was the first person to walk on the Moon?",
                "Choice_1" => "Yuri Gagarin",
                "Choice_2" => "Neil Armstrong",
                "Choice_3" => "Buzz Aldrin",
                "Choice_4" => "Michael Collins",
                "Answer" => "Choice_2",
            ],
            [
                "question" => "What is the smallest country in the world?",
                "Choice_1" => "Monaco",
                "Choice_2" => "Vatican City",
                "Choice_3" => "San Marino",
                "Choice_4" => "Liechtenstein",
                "Answer" => "Choice_2",
            ],
            [
                "question" => "Which organ purifies our blood?",
                "Choice_1" => "Heart",
                "Choice_2" => "Lungs",
                "Choice_3" => "Liver",
                "Choice_4" => "Kidneys",
                "Answer" => "Choice_4",
            ],
            [
                "question" => "Which is the largest desert in the world?",
                "Choice_1" => "Sahara Desert",
                "Choice_2" => "Arabian Desert",
                "Choice_3" => "Gobi Desert",
                "Choice_4" => "Kalahari Desert",
                "Answer" => "Choice_1",
            ],
            [
                "question" => "What is the boiling point of water?",
                "Choice_1" => "90°C",
                "Choice_2" => "95°C",
                "Choice_3" => "100°C",
                "Choice_4" => "105°C",
                "Answer" => "Choice_3",
            ],
            [
                "question" => "What is the largest internal organ in the human body?",
                "Choice_1" => "Heart",
                "Choice_2" => "Lungs",
                "Choice_3" => "Liver",
                "Choice_4" => "Brain",
                "Answer" => "Choice_3",
            ],
            [
                "question" => "Which continent is known as the 'Dark Continent'?",
                "Choice_1" => "Asia",
                "Choice_2" => "Africa",
                "Choice_3" => "South America",
                "Choice_4" => "Antarctica",
                "Answer" => "Choice_2",
            ],
            [
                "question" => "What is the most widely spoken language in the world?",
                "Choice_1" => "English",
                "Choice_2" => "Spanish",
                "Choice_3" => "Mandarin Chinese",
                "Choice_4" => "Hindi",
                "Answer" => "Choice_3",
            ],
            [
                "question" => "Who developed the theory of relativity?",
                "Choice_1" => "Isaac Newton",
                "Choice_2" => "Albert Einstein",
                "Choice_3" => "Nikola Tesla",
                "Choice_4" => "Galileo Galilei",
                "Answer" => "Choice_2",
            ],
            [
                "question" => "What is the smallest bone in the human body?",
                "Choice_1" => "Stapes",
                "Choice_2" => "Femur",
                "Choice_3" => "Tibia",
                "Choice_4" => "Ulna",
                "Answer" => "Choice_1",
            ],
            [
                "question" => "What is the capital of Australia?",
                "Choice_1" => "Sydney",
                "Choice_2" => "Melbourne",
                "Choice_3" => "Canberra",
                "Choice_4" => "Brisbane",
                "Answer" => "Choice_3",
            ],
            [
                "question" => "Which country gifted the Statue of Liberty to the USA?",
                "Choice_1" => "Spain",
                "Choice_2" => "Italy",
                "Choice_3" => "France",
                "Choice_4" => "Germany",
                "Answer" => "Choice_3",
            ],
            [
                "question" => "What is the main gas found in the air we breathe?",
                "Choice_1" => "Oxygen",
                "Choice_2" => "Carbon Dioxide",
                "Choice_3" => "Nitrogen",
                "Choice_4" => "Hydrogen",
                "Answer" => "Choice_3",
            ],
            [
                "question" => "Which is the largest planet in our solar system?",
                "Choice_1" => "Earth",
                "Choice_2" => "Saturn",
                "Choice_3" => "Jupiter",
                "Choice_4" => "Neptune",
                "Answer" => "Choice_3",
            ],
            [
                "question" => "What is the hardest rock?",
                "Choice_1" => "Granite",
                "Choice_2" => "Marble",
                "Choice_3" => "Limestone",
                "Choice_4" => "Diamond",
                "Answer" => "Choice_4",
            ],
            [
                "question" => "Who invented the telephone?",
                "Choice_1" => "Thomas Edison",
                "Choice_2" => "Nikola Tesla",
                "Choice_3" => "Alexander Graham Bell",
                "Choice_4" => "Guglielmo Marconi",
                "Answer" => "Choice_3",
            ],
            [
                "question" => "What is the chemical symbol for gold?",
                "Choice_1" => "Au",
                "Choice_2" => "Ag",
                "Choice_3" => "Gd",
                "Choice_4" => "Ge",
                "Answer" => "Choice_1",
            ],
            [
                "question" => "What is the longest bone in the human body?",
                "Choice_1" => "Humerus",
                "Choice_2" => "Femur",
                "Choice_3" => "Tibia",
                "Choice_4" => "Fibula",
                "Answer" => "Choice_2",
            ],
            [
                "question" => "Which planet is known as the Earth's twin?",
                "Choice_1" => "Mars",
                "Choice_2" => "Mercury",
                "Choice_3" => "Venus",
                "Choice_4" => "Neptune",
                "Answer" => "Choice_3",
            ],
            [
                "question" => "What is the largest ocean on Earth?",
                "Choice_1" => "Atlantic Ocean",
                "Choice_2" => "Indian Ocean",
                "Choice_3" => "Pacific Ocean",
                "Choice_4" => "Arctic Ocean",
                "Answer" => "Choice_3",
            ],
            [
                "question" => "What is the currency of the United Kingdom?",
                "Choice_1" => "Euro",
                "Choice_2" => "Dollar",
                "Choice_3" => "Pound Sterling",
                "Choice_4" => "Franc",
                "Answer" => "Choice_3",
            ],
            [
                "question" => "Which country is known as the Land of the Rising Sun?",
                "Choice_1" => "China",
                "Choice_2" => "Japan",
                "Choice_3" => "South Korea",
                "Choice_4" => "Thailand",
                "Answer" => "Choice_2",
            ],
            [
                "question" => "What is the main ingredient in bread?",
                "Choice_1" => "Rice",
                "Choice_2" => "Flour",
                "Choice_3" => "Sugar",
                "Choice_4" => "Corn",
                "Answer" => "Choice_2",
            ],
            [
                "question" => "Who was the first man in space?",
                "Choice_1" => "Neil Armstrong",
                "Choice_2" => "Buzz Aldrin",
                "Choice_3" => "Yuri Gagarin",
                "Choice_4" => "Alan Shepard",
                "Answer" => "Choice_3",
            ],
            [
                "question" => "What is the capital of Italy?",
                "Choice_1" => "Milan",
                "Choice_2" => "Venice",
                "Choice_3" => "Rome",
                "Choice_4" => "Florence",
                "Answer" => "Choice_3",
            ],
            [
                "question" => "Which instrument has 88 keys?",
                "Choice_1" => "Guitar",
                "Choice_2" => "Violin",
                "Choice_3" => "Piano",
                "Choice_4" => "Flute",
                "Answer" => "Choice_3",
            ],
            [
                "question" => "What is the primary component of steel?",
                "Choice_1" => "Copper",
                "Choice_2" => "Iron",
                "Choice_3" => "Aluminum",
                "Choice_4" => "Zinc",
                "Answer" => "Choice_2",
            ],
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
