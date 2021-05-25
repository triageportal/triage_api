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
            ['id' => 1,'value' => 0, 'eng' => 'No formal education'],
            ['id' => 2,'value' => 0, 'eng' => 'Primary education'],
            ['id' => 3,'value' => 0, 'eng' => 'Secondary education or high school'],
            ['id' => 4,'value' => 0, 'eng' => 'GED'],
            ['id' => 5,'value' => 0, 'eng' => 'Vocational qualification'],
            ['id' => 6,'value' => 0, 'eng' => 'Bachelor\'s degree'],
            ['id' => 7,'value' => 0, 'eng' => 'Master\'s degree'],
            ['id' => 8,'value' => 0, 'eng' => 'Doctorate or higher'],
            //Employment
            ['id' => 9,'value' => 0, 'eng' => 'Employed'],
            ['id' => 10,'value' => 0, 'eng' => 'Self employed'],
            ['id' => 11,'value' => 0, 'eng' => 'Unemployed'],
            ['id' => 12,'value' => 0, 'eng' => 'Student'],
            ['id' => 13,'value' => 0, 'eng' => 'Retired'],
            ['id' => 14,'value' => 0, 'eng' => 'Unable to work'],
            //Race
            ['id' => 15,'value' => 0, 'eng' => 'American Indian or Alaska Native'],
            ['id' => 16,'value' => 0, 'eng' => 'Asian'],
            ['id' => 17,'value' => 0, 'eng' => 'Black or African American'],
            ['id' => 18,'value' => 0, 'eng' => 'Causasian'],
            ['id' => 19,'value' => 0, 'eng' => 'Hispanic, Latino or Spanish origin'],
            ['id' => 20,'value' => 0, 'eng' => 'Native Hawaiian or Other Pacific Islander'],            
            ['id' => 21,'value' => 0, 'eng' => 'Any other ethnic group'],
            //Marital status
            ['id' => 22,'value' => 0, 'eng' => 'Single'],
            ['id' => 23,'value' => 0, 'eng' => 'Married'],
            ['id' => 24,'value' => 0, 'eng' => 'Widowed'],
            ['id' => 25,'value' => 0, 'eng' => 'Separated'],
            ['id' => 26,'value' => 0, 'eng' => 'Divorced'],
            ['id' => 27,'value' => 0, 'eng' => 'Open Relationship']   

        ];

        Response::insert($response);


    }

    private function populateQuestions(){

        Questions::truncate();

        $questions = [

            ['category_id' => 1,'id' => 1,'eng' => 'Education'],
            ['category_id' => 1,'id' => 2,'eng' => 'Employement'],
            ['category_id' => 1,'id' => 3,'eng' => 'Race/Ethnicity'],
            ['category_id' => 1,'id' => 4,'eng' => 'Marital status']

        ];

        Questions::insert($questions);

    }

    private function populateCategory(){

        Category::truncate();

        $categories = [

            ['id'=> 1, 'eng' => 'Demographic']
           
        ];

        Category::insert($categories);

    }
}
