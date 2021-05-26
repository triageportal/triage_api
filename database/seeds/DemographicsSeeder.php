<?php

use Illuminate\Database\Seeder;
use App\triage\demographics\Category;
use App\triage\demographics\Questions;
use App\triage\demographics\Response;
use App\triage\demographics\QuestionResponseLk;

class DemographicsSeeder extends Seeder
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
            ['question_id' => 1, 'response_id' => 6],
            ['question_id' => 1, 'response_id' => 7],
            ['question_id' => 1, 'response_id' => 8],
            ['question_id' => 2, 'response_id' => 9],
            ['question_id' => 2, 'response_id' => 10],
            ['question_id' => 2, 'response_id' => 11],
            ['question_id' => 2, 'response_id' => 12],
            ['question_id' => 2, 'response_id' => 13],
            ['question_id' => 2, 'response_id' => 14],
            ['question_id' => 3, 'response_id' => 15],
            ['question_id' => 3, 'response_id' => 16],
            ['question_id' => 3, 'response_id' => 17],
            ['question_id' => 3, 'response_id' => 18],
            ['question_id' => 3, 'response_id' => 19],
            ['question_id' => 3, 'response_id' => 20],
            ['question_id' => 3, 'response_id' => 21],
            ['question_id' => 4, 'response_id' => 22],
            ['question_id' => 4, 'response_id' => 23],
            ['question_id' => 4, 'response_id' => 24],
            ['question_id' => 4, 'response_id' => 25],
            ['question_id' => 4, 'response_id' => 26],
            ['question_id' => 4, 'response_id' => 27]

        ];

        QuestionResponseLk::insert($link);

    }

    private function populateResponse(){

        Response::truncate();

        $response = [
            //Education
            ['id' => 1,'value' => 0, 'eng' => 'No formal education', 'rus' => 'Без образования'],
            ['id' => 2,'value' => 0, 'eng' => 'Primary education', 'rus' => 'Начальное образование'],
            ['id' => 3,'value' => 0, 'eng' => 'Secondary education or high school', 'rus' => 'Среднее образование или средняя школа'],
            ['id' => 4,'value' => 0, 'eng' => 'GED', 'rus' => 'Диплом об общем образовании'],
            ['id' => 5,'value' => 0, 'eng' => 'Vocational qualification', 'rus' => 'Профессиональная квалификация'],
            ['id' => 6,'value' => 0, 'eng' => 'Bachelor\'s degree', 'rus' => 'Степень бакалавра'],
            ['id' => 7,'value' => 0, 'eng' => 'Master\'s degree', 'rus' => 'Степень магистра'],
            ['id' => 8,'value' => 0, 'eng' => 'Doctorate or higher', 'rus' => 'Докторантура или выше'],
            //Employment
            ['id' => 9,'value' => 0, 'eng' => 'Employed', 'rus' => 'Работаю'],
            ['id' => 10,'value' => 0, 'eng' => 'Self employed', 'rus' => 'Частный предприниматель'],
            ['id' => 11,'value' => 0, 'eng' => 'Unemployed', 'rus' => 'Безработный'],
            ['id' => 12,'value' => 0, 'eng' => 'Student', 'rus' => 'Студент'],
            ['id' => 13,'value' => 0, 'eng' => 'Retired', 'rus' => 'На пенсии'],
            ['id' => 14,'value' => 0, 'eng' => 'Unable to work', 'rus' => 'Не могу работать'],
            //Race
            ['id' => 15,'value' => 0, 'eng' => 'American Indian or Alaska Native', 'rus' => 'Американский индеец или коренной житель Аляски'],
            ['id' => 16,'value' => 0, 'eng' => 'Asian', 'rus' => 'Азиат'],
            ['id' => 17,'value' => 0, 'eng' => 'Black or African American', 'rus' => 'Афроамериканец'],
            ['id' => 18,'value' => 0, 'eng' => 'Caucasian', 'rus' => 'Белый'],
            ['id' => 19,'value' => 0, 'eng' => 'Hispanic, Latino or Spanish origin', 'rus' => 'Латиноамериканец или испанское происхождение'],
            ['id' => 20,'value' => 0, 'eng' => 'Native Hawaiian or Other Pacific Islander', 'rus' => 'Коренной житель Гавайев или других тихоокеанских островов'],
            ['id' => 21,'value' => 0, 'eng' => 'Any other ethnic group', 'rus' => 'Любая другая этническая группа'],
            //Marital status
            ['id' => 22,'value' => 0, 'eng' => 'Single', 'rus' => 'Холост'],
            ['id' => 23,'value' => 0, 'eng' => 'Married', 'rus' => 'Женатый'],
            ['id' => 24,'value' => 0, 'eng' => 'Widowed', 'rus' => 'Овдовевший'],
            ['id' => 25,'value' => 0, 'eng' => 'Separated', 'rus' => 'Разведен (неофициально)'],
            ['id' => 26,'value' => 0, 'eng' => 'Divorced', 'rus' => 'Разведен (официально)'],
            ['id' => 27,'value' => 0, 'eng' => 'Open Relationship', 'rus' => 'Свободные отношения']

        ];

        Response::insert($response);


    }

    private function populateQuestions(){

        Questions::truncate();

        $questions = [

            ['category_id' => 1,'id' => 1,'eng' => 'Education', 'rus' => 'Образование'],
            ['category_id' => 1,'id' => 2,'eng' => 'Employement', 'rus' => 'Работа'],
            ['category_id' => 1,'id' => 3,'eng' => 'Race/Ethnicity', 'rus' => 'Раса / этническая принадлежность'],
            ['category_id' => 1,'id' => 4,'eng' => 'Marital status', 'rus' => 'Семейное положение']

        ];

        Questions::insert($questions);

    }

    private function populateCategory(){

        Category::truncate();

        $categories = [

            ['id'=> 1, 'eng' => 'Demographic', 'rus' => 'демография']

        ];

        Category::insert($categories);

    }
}
