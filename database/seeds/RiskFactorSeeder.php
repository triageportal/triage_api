<?php

use Illuminate\Database\Seeder;
use App\triage\risk_factor\Category;
use App\triage\risk_factor\Questions;
use App\triage\risk_factor\Response;
use App\triage\risk_factor\QuestionResponseLk;

class RiskFactorSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->populateCategory();
        $this->populateQuestions();
        $this->populateResponse();
        $this->linkQuestionResponse();
    }

    private function linkQuestionResponse(){

        QuestionResponseLk::truncate();

        $link = [

            ['question_id' => 1, 'response_id' => 1],
            ['question_id' => 1, 'response_id' => 2],
            ['question_id' => 1, 'response_id' => 3],
            ['question_id' => 1, 'response_id' => 4],
            ['question_id' => 1, 'response_id' => 5],
            ['question_id' => 2, 'response_id' => 6],
            ['question_id' => 2, 'response_id' => 7],
            ['question_id' => 3, 'response_id' => 6],
            ['question_id' => 3, 'response_id' => 7],
            ['question_id' => 4, 'response_id' => 6],
            ['question_id' => 4, 'response_id' => 7],
            ['question_id' => 5, 'response_id' => 6],
            ['question_id' => 5, 'response_id' => 7],
            ['question_id' => 6, 'response_id' => 6],
            ['question_id' => 6, 'response_id' => 7],
            ['question_id' => 7, 'response_id' => 6],
            ['question_id' => 7, 'response_id' => 7]

        ];

        QuestionResponseLk::insert($link);

    }

    private function populateResponse(){

        Response::truncate();

        $response = [

            //Lifestyle
            ['id' => 1,'value' => 0,
            'eng' => 'Highly active (More than 3 miles of daily walk or equivalent exersise)',
            'rus' => 'Высокая активность (ежедневная прогулка более 3 миль или аналогичное упражнение)'],

            ['id' => 2,'value' => 0,
            'eng' => 'Lightly active (Intentional exercise every day for at least 30 minutes)',
            'rus' => 'Слабая активность (намеренные упражнения каждый день не менее 30 минут)'],

            ['id' => 3,'value' => 0,
            'eng' => 'Moderately active (1.5-3 miles of daily walk or equivalent exersise)',
            'rus' => 'Умеренно активный (1,5-3 мили ежедневной ходьбы или аналогичное упражнение)'],

            ['id' => 4,'value' => 0,
            'eng' => 'Non active',
            'rus' => 'Не активен'],

            ['id' => 5,'value' => 0,
            'eng' => 'Sedentary active (Less than 30 minutes a day of intentional exercise)',
            'rus' => 'Сидячий образ жизни (менее 30 минут преднамеренных упражнений в день)'],
            //Smoking, ALchohol, Drugs, High LDL, High Blood Pressure, Obesity
            ['id' => 6,'value' => 0,
            'eng' => 'Yes',
            'rus' => 'да'],

            ['id' => 7,'value' => 0,
            'eng' => 'No',
            'rus' => 'Нет']

        ];

        Response::insert($response);


    }

    private function populateQuestions(){

        Questions::truncate();

        $questions = [

            ['category_id' => 1,'id' => 1,'eng' => 'Lifestyle', 'rus'=>'Образ жизни'],
            ['category_id' => 1,'id' => 2,'eng' => 'Smoking', 'rus'=>'Курение'],
            ['category_id' => 1,'id' => 3,'eng' => 'Alchohol', 'rus'=>'Алкоголь'],
            ['category_id' => 1,'id' => 4,'eng' => 'Drugs', 'rus'=>'Наркотики'],
            ['category_id' => 1,'id' => 5,'eng' => 'High LDL(\'bad\' cholesterol)', 'rus'=>'Высокий ЛПНП (холестерин)'],
            ['category_id' => 1,'id' => 6,'eng' => 'High blood pressure', 'rus'=>'Высокое кровяное давление'],
            ['category_id' => 1,'id' => 7,'eng' => 'Obesity', 'rus'=>'Ожирение']

        ];

        Questions::insert($questions);

    }

    private function populateCategory(){

        Category::truncate();

        $categories = [

            ['id'=> 1, 'eng' => 'Risk Factors', 'rus' => 'Факторы риска']

        ];

        Category::insert($categories);

    }
}
