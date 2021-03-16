<?php

use Illuminate\Database\Seeder;
use App\triage\acss\Category;
use App\triage\acss\Questions;
use App\triage\acss\Response;
use App\triage\acss\QuestionResponseLk;

class AcssSeeder extends Seeder
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

            ['question_id' => 1, 'response_id' => 5],
            ['question_id' => 1, 'response_id' => 6],
            ['question_id' => 1, 'response_id' => 7],
            ['question_id' => 1, 'response_id' => 8],
            ['question_id' => 2, 'response_id' => 1],
            ['question_id' => 2, 'response_id' => 2],
            ['question_id' => 2, 'response_id' => 3],
            ['question_id' => 2, 'response_id' => 4],
            ['question_id' => 3, 'response_id' => 1],
            ['question_id' => 3, 'response_id' => 2],
            ['question_id' => 3, 'response_id' => 3],
            ['question_id' => 3, 'response_id' => 4],
            ['question_id' => 4, 'response_id' => 1],
            ['question_id' => 4, 'response_id' => 2],
            ['question_id' => 4, 'response_id' => 3],
            ['question_id' => 4, 'response_id' => 4],
            ['question_id' => 5, 'response_id' => 1],
            ['question_id' => 5, 'response_id' => 2],
            ['question_id' => 5, 'response_id' => 3],
            ['question_id' => 5, 'response_id' => 4],
            ['question_id' => 6, 'response_id' => 1],
            ['question_id' => 6, 'response_id' => 2],
            ['question_id' => 6, 'response_id' => 3],
            ['question_id' => 6, 'response_id' => 4],
            ['question_id' => 7, 'response_id' => 1],
            ['question_id' => 7, 'response_id' => 2],
            ['question_id' => 7, 'response_id' => 3],
            ['question_id' => 7, 'response_id' => 4],
            ['question_id' => 8, 'response_id' => 1],
            ['question_id' => 8, 'response_id' => 2],
            ['question_id' => 8, 'response_id' => 3],
            ['question_id' => 8, 'response_id' => 4],
            ['question_id' => 9, 'response_id' => 1],
            ['question_id' => 9, 'response_id' => 2],
            ['question_id' => 9, 'response_id' => 3],
            ['question_id' => 9, 'response_id' => 4],
            ['question_id' => 10, 'response_id' => 9],
            ['question_id' => 10, 'response_id' => 10],
            ['question_id' => 10, 'response_id' => 11],
            ['question_id' => 10, 'response_id' => 12],
            ['question_id' => 11, 'response_id' => 13],
            ['question_id' => 11, 'response_id' => 14],
            ['question_id' => 11, 'response_id' => 15],
            ['question_id' => 11, 'response_id' => 16],
            ['question_id' => 12, 'response_id' => 17],
            ['question_id' => 12, 'response_id' => 18],
            ['question_id' => 12, 'response_id' => 19],
            ['question_id' => 12, 'response_id' => 20],
            ['question_id' => 13, 'response_id' => 21],
            ['question_id' => 13, 'response_id' => 22],
            ['question_id' => 13, 'response_id' => 23],
            ['question_id' => 13, 'response_id' => 24],
            ['question_id' => 14, 'response_id' => 25],
            ['question_id' => 14, 'response_id' => 26],
            ['question_id' => 15, 'response_id' => 25],
            ['question_id' => 15, 'response_id' => 26],
            ['question_id' => 16, 'response_id' => 25],
            ['question_id' => 16, 'response_id' => 26],
            ['question_id' => 17, 'response_id' => 25],
            ['question_id' => 17, 'response_id' => 26],
            ['question_id' => 18, 'response_id' => 25],
            ['question_id' => 18, 'response_id' => 26],
            ['question_id' => 19, 'response_id' => 27],
            ['question_id' => 19, 'response_id' => 28],
            ['question_id' => 19, 'response_id' => 29],
            ['question_id' => 19, 'response_id' => 30],
            ['question_id' => 19, 'response_id' => 31],
            ['question_id' => 20, 'response_id' => 32],
            ['question_id' => 20, 'response_id' => 33]

        ];

        QuestionResponseLk::insert($link);

    }

    private function populateResponse(){

        Response::truncate();

        $response = [

            ['id' => 1,'value' => 0, 'eng' => 'None'],
            ['id' => 2,'value' => 1, 'eng' => 'Yes, mild'],
            ['id' => 3,'value' => 2, 'eng' => 'Yes, moderate'],
            ['id' => 4,'value' => 3, 'eng' => 'Yes, severe'],
            ['id' => 5,'value' => 0, 'eng' => 'None; up to 4 times per day'],
            ['id' => 6,'value' => 1, 'eng' => 'Yes, mild; 5‐6 times/day'],
            ['id' => 7,'value' => 2, 'eng' => 'Yes, moderate; 7‐8 times/day'],
            ['id' => 8,'value' => 3, 'eng' => 'Yes, severe; 9‐10 or more times/day'],
            ['id' => 9,'value' => 0, 'eng' => 'None; (≤99.5˚F)'],
            ['id' => 10,'value' => 1, 'eng' => 'Yes, mild; (99.6˚F-100.2˚F)'],
            ['id' => 11,'value' => 2, 'eng' => 'Yes, moderate; (100.3˚F-102.0˚F)'],
            ['id' => 12,'value' => 3, 'eng' => 'Yes, severe; (≥102.1 ˚F)'],
            ['id' => 13,'value' => 0, 'eng' => 'Feeling no discomfort (No symptoms at all. I feel as good as usual)'],
            ['id' => 14,'value' => 1, 'eng' => 'Feeling mild discomfort (I feel a somewhat worse than usual)'],
            ['id' => 15,'value' => 2, 'eng' => 'Feeling moderate discomfort (I feel quite bad)'],
            ['id' => 16,'value' => 3, 'eng' => 'Feeling severe discomfort (I feel terrible)'],
            ['id' => 17,'value' => 0, 'eng' => 'Not interfered at all (Working as usual on a working day)'],
            ['id' => 18,'value' => 1, 'eng' => 'Mildly interfered (Working is associated with some discomfort)'],
            ['id' => 19,'value' => 2, 'eng' => 'Moderately interfered (Daily work requires effort)'],
            ['id' => 20,'value' => 3, 'eng' => 'Severely interfered (Usual work or activities are almost impossible)'],
            ['id' => 21,'value' => 0, 'eng' => 'Not interfered at all (Able to enjoy normal social activities)'],
            ['id' => 22,'value' => 1, 'eng' => 'Mildly interfered (Less activities than usual)'],
            ['id' => 23,'value' => 2, 'eng' => 'Moderately interfered (Have to spend much time at home)'],
            ['id' => 24,'value' => 3, 'eng' => 'Severely interfered (Symptoms prevent me from leaving home)'],
            ['id' => 25,'value' => 0, 'eng' => 'No'],
            ['id' => 26,'value' => 1, 'eng' => 'Yes'],
            ['id' => 27,'value' => 0, 'eng' => 'Yes I feel normal (All symptoms have gone away)'],
            ['id' => 28,'value' => 1, 'eng' => 'Yes, I feel much better (Most of symptoms have gone away)'],
            ['id' => 29,'value' => 2, 'eng' => 'Yes, I feel somewhat better (Only some symptoms are gone)'],
            ['id' => 30,'value' => 3, 'eng' => 'No, there are barely any changes (I still have about the same symptoms)'],
            ['id' => 31,'value' => 4, 'eng' => 'Yes, I feel worse (My condition is worse)'],
            ['id' => 32,'value' => 0, 'eng' => 'Initial'],
            ['id' => 33,'value' => 1, 'eng' => 'Follow up']

        ];

        Response::insert($response);


    }

    private function populateQuestions(){

        Questions::truncate();

        $questions = [

            ['category_id' => 1,'id' => 1,'eng' => 'Frequent urination of small amounts of urine (going to the toilet very often)'],
            ['category_id' => 1,'id' => 2,'eng' => 'Urgent urination (a sudden and uncontrollable urge to urinate)'],
            ['category_id' => 1,'id' => 3,'eng' => 'Feeling burning pain when urinating'],
            ['category_id' => 1,'id' => 4,'eng' => 'Feeling incomplete bladder emptying (still feel like you could urinate again'],
            ['category_id' => 1,'id' => 5,'eng' => 'Feeling pain not associated with urination in the lower abdomen (below the belly button)'],
            ['category_id' => 1,'id' => 6,'eng' => 'Blood seen in urine (without menses)'],
            ['category_id' => 2,'id' => 7,'eng' => 'Flank pain (pain in one or both sides of the lower back)'],
            ['category_id' => 2,'id' => 8,'eng' => 'Abnormal vaginal discharge (amount, color and/or odor)'],
            ['category_id' => 2,'id' => 9,'eng' => 'Discharge from the urethra (urinary opening) , without urination'],
            ['category_id' => 2,'id' => 10,'eng' => 'Fever/high body temperature (Please indicate if measured)'],
            ['category_id' => 3,'id' => 11,'eng' => 'Please indicate how much discomfort you have experienced because of your symptoms in the past 24 hours (Mark 
            only one answer that suits you best)'],
            ['category_id' => 3,'id' => 12,'eng' => 'Please indicate how your symptoms have interfered with your everyday activities/work in the past 24 hours (Mark only 
            one answer that suits you best)'],
            ['category_id' => 3,'id' => 13,'eng' => 'Please indicate how your symptoms have interfered with your social activities (visiting people, meeting with friends, 
            etc) in the past 24 hours (Mark only one answer that suits you best)'],
            ['category_id' => 4,'id' => 14,'eng' => 'Menstruation (Menses) ?'],
            ['category_id' => 4,'id' => 15,'eng' => 'Premenstrual syndrome (PMS) ?'],
            ['category_id' => 4,'id' => 16,'eng' => 'Signs of menopausal syndrome (e.g. hot flashes) ?'],
            ['category_id' => 4,'id' => 17,'eng' => 'Pregnancy'],
            ['category_id' => 4,'id' => 18,'eng' => 'Known (diagnosed) diabetes mellitus (high sugar)'],
            ['category_id' => 5,'id' => 19,'eng' => 'Please indicate if you experienced any changes in your symptoms since the first time you completed this questionnaire:'],          
            ['category_id' => 6,'id' => 20,'eng' => 'Please indicate visit type']
        ];

        Questions::insert($questions);

    }

    private function populateCategory(){

        Category::truncate();

        $categories = [

            ['id'=> 1, 'eng' => 'Typical'],
            ['id'=> 2,'eng' => 'Differential'],
            ['id'=> 3,'eng' => 'Quality of life'],
            ['id'=> 4,'eng' => 'Additional'],
            ['id'=> 5,'eng' => 'Dynamics'],
            ['id'=> 6,'eng' => 'Visit Type']

        ];

        Category::insert($categories);

    }
}
