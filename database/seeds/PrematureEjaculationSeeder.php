<?php

use Illuminate\Database\Seeder;
use App\triage\premature_ejaculation\Category;
use App\triage\premature_ejaculation\Questions;
use App\triage\premature_ejaculation\Response;
use App\triage\premature_ejaculation\QuestionResponseLk;

class PrematureEjaculationSeeder extends Seeder
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

//Question 1 Response Link.
            ['question_id' => 1, 'response_id' => 1],
            ['question_id' => 1, 'response_id' => 2],
            ['question_id' => 1, 'response_id' => 3],
            ['question_id' => 1, 'response_id' => 4],
            ['question_id' => 1, 'response_id' => 5],

//Question 2 Response Link.
            ['question_id' => 2, 'response_id' => 6],
            ['question_id' => 2, 'response_id' => 7],
            ['question_id' => 2, 'response_id' => 8],
            ['question_id' => 2, 'response_id' => 9],
            ['question_id' => 2, 'response_id' => 10],

//Question 3 Response Link.
            ['question_id' => 3, 'response_id' => 11],
            ['question_id' => 3, 'response_id' => 12],
            ['question_id' => 3, 'response_id' => 13],
            ['question_id' => 3, 'response_id' => 14],
            ['question_id' => 3, 'response_id' => 15],

//Question 4 Response Link.
            ['question_id' => 4, 'response_id' => 16],
            ['question_id' => 4, 'response_id' => 17],
            ['question_id' => 4, 'response_id' => 18],
            ['question_id' => 4, 'response_id' => 19],
            ['question_id' => 4, 'response_id' => 20],

//Question 5 Response Link.
            ['question_id' => 5, 'response_id' => 21],
            ['question_id' => 5, 'response_id' => 22],
            ['question_id' => 5, 'response_id' => 23],
            ['question_id' => 5, 'response_id' => 24],
            ['question_id' => 5, 'response_id' => 25],

//Question 6 Response Link.
            ['question_id' => 6, 'response_id' => 26],
            ['question_id' => 6, 'response_id' => 27],
            ['question_id' => 6, 'response_id' => 28],
            ['question_id' => 6, 'response_id' => 29],
            ['question_id' => 6, 'response_id' => 30],

//Question 7 Response Link.
            ['question_id' => 7, 'response_id' => 31],
            ['question_id' => 7, 'response_id' => 32],
            ['question_id' => 7, 'response_id' => 33],
            ['question_id' => 7, 'response_id' => 34],
            ['question_id' => 7, 'response_id' => 35],

//Question 8 Response Link.
            ['question_id' => 8, 'response_id' => 36],
            ['question_id' => 8, 'response_id' => 37],
            ['question_id' => 8, 'response_id' => 38],
            ['question_id' => 8, 'response_id' => 39],
            ['question_id' => 8, 'response_id' => 40],

//Question 9 Response Link.
            ['question_id' => 9, 'response_id' => 41],
            ['question_id' => 9, 'response_id' => 42]
        ];

        QuestionResponseLk::insert($link);

    }

    private function populateResponse(){

        Response::truncate();

        $response = [

//Question 1 responses.
            ['id' => 1,'value' => 0,
            'eng' => 'easy, can control',
            'rus' => 'несложно, могу контролировать'],

            ['id' => 2,'value' => 1,
            'eng' => 'can be a little difficult',
            'rus' => 'бывает немного сложно'],

            ['id' => 3,'value' => 2,
            'eng' => 'difficult',
            'rus' => 'затруднительно'],

            ['id' => 4,'value' => 3,
            'eng' => 'very hard',
            'rus' => 'очень сложно'],

            ['id' => 5,'value' => 4,
            'eng' => 'impossible',
            'rus' => 'невозможно'],

//Question 2 responses.
            ['id' => 6,'value' => 0,
            'eng' => 'almost never or rarely',
            'rus' => 'почти никогда или крайне редко'],

            ['id' => 7,'value' => 1,
            'eng' => 'less than half of  the cases',
            'rus' => 'меньше чем в половине случаев'],

            ['id' => 8,'value' => 2,
            'eng' => 'about half the cases',
            'rus' => 'примерно в половине случаев'],

            ['id' => 9,'value' => 3,
            'eng' => 'more than half of the cases',
            'rus' => 'больше чем в половине случаев'],

            ['id' => 10,'value' => 4,
            'eng' => 'almost always or always',
            'rus' => 'почти всегда или всегда'],

//Question 3 responses.
            ['id' => 11,'value' => 0,
            'eng' => 'sometimes or rarely',
            'rus' => 'иногда или редко'],

            ['id' => 12,'value' => 1,
            'eng' => 'less than half of  the cases',
            'rus' => 'меньше чем в половине случаев'],

            ['id' => 13,'value' => 2,
            'eng' => 'about half the cases',
            'rus' => 'примерно в половине случаев'],

            ['id' => 14,'value' => 3,
            'eng' => 'more than half of the cases',
            'rus' => 'больше чем в половине случаев'],

            ['id' => 15,'value' => 4,
            'eng' => 'almost always or always',
            'rus' => 'почти всегда или всегда'],

//Question 4 responses.
            ['id' => 16,'value' => 0,
            'eng' => '7-14 minutes and more',
            'rus' => 'от 7-14 минут и более'],

            ['id' => 17,'value' => 1,
            'eng' => 'from 3 to 6 minutes',
            'rus' => 'от 3 до 6 минут'],

            ['id' => 18,'value' => 2,
            'eng' => 'from 1 to 2 minutes',
            'rus' => 'от 1 до 2 минут'],

            ['id' => 19,'value' => 3,
            'eng' => 'less than 1 minute',
            'rus' => 'менее   1 минуты'],

            ['id' => 20,'value' => 4,
            'eng' => '30 seconds',
            'rus' => 'до 30 секунд'],

//Question 5 responses.
            ['id' => 21,'value' => 0,
            'eng' => 'occurs very rarely, and only when I change partner, it\'s OK with constant',
            'rus' => 'возникает очень редко и  только при смене партнерши, с постоянной все нормально'],

            ['id' => 22,'value' => 1,
            'eng' => 'sometimes occurs when I change the partner',
            'rus' => 'иногда возникает при смене партнерши'],

            ['id' => 23,'value' => 2,
            'eng' => 'half of the cases when you change partner',
            'rus' => 'в половине случаев при смене партнерши'],

            ['id' => 24,'value' => 3,
            'eng' => 'more than half of cases when you change partner',
            'rus' => 'больше чем в половине случаев при смене партнерши'],


            ['id' => 25,'value' => 4,
            'eng' => 'no, not only, occurs even with a constant partner',
            'rus' => 'нет, не только, случается даже с постоянной партнершей'],

//Question 6 responses.
            ['id' => 26,'value' => 0,
            'eng' => 'yes, quite',
            'rus' => 'да, вполне'],


            ['id' => 27,'value' => 1,
            'eng' => 'more \'yes\' than \'no\'',
            'rus' => 'больше «да», чем «нет»'],


            ['id' => 28,'value' => 2,
            'eng' => 'about half the cases',
            'rus' => 'примерно в половине случаев'],


            ['id' => 29,'value' => 3,
            'eng' => 'more \'no\' than \'yes\'',
            'rus' => 'больше «нет», чем «да»'],


            ['id' => 30,'value' => 4,
            'eng' => 'no',
            'rus' => 'нет'],

//Question 7 responses.
            ['id' => 31,'value' => 0,
            'eng' => 'no (never)',
            'rus' => 'нет (никогда)'],

            ['id' => 32,'value' => 1,
            'eng' => 'rarely insignificantly',
            'rus' => 'редко, незначительно'],

            ['id' => 33,'value' => 2,
            'eng' => 'sometimes, but not always',
            'rus' => 'бывает, но не всегда'],

            ['id' => 34,'value' => 3,
            'eng' => 'very often',
            'rus' => 'очень часто'],

            ['id' => 35,'value' => 4,
            'eng' => 'always',
            'rus' => 'всегда'],

//Question 8 responses.
            ['id' => 36,'value' => 0,
            'eng' => 'no (never)',
            'rus' => 'нет (никогда)'],

            ['id' => 37,'value' => 1,
            'eng' => 'sometimes bit bothered',
            'rus' => 'немного беспокоит, иногда'],

            ['id' => 38,'value' => 2,
            'eng' => 'about half the cases',
            'rus' => 'примерно в половине случаев'],

            ['id' => 39,'value' => 3,
            'eng' => 'very',
            'rus' => 'очень'],

            ['id' => 40,'value' => 4,
            'eng' => 'exceedingly (always)',
            'rus' => 'чрезвычайно (всегда)'],

//Question 9 responses.
            ['id' => 41,'value' => 0,
            'eng' => 'yes',
            'rus' => 'Да'],

            ['id' => 42,'value' => 0,
            'eng' => 'no',
            'rus' => 'Нет'],
        ];

        Response::insert($response);


    }

    private function populateQuestions(){

        Questions::truncate();

        $questions = [

            ['category_id' => 1,'id' => 1,
            'eng' => 'Rate in scores how difficult  for you hold up (control) offensive of  ejaculation?',
            'rus'=> 'Оцените в баллах, насколько сложным является для вас задержать (контролировать) наступление  эякуляции?'],

            ['category_id' => 1,'id' => 2,
            'eng' => 'How often your ejaculation occurs earlier than desired moment?',
            'rus'=> 'Как часто у вас эякуляция происходит ранее желаемого момента?'],

            ['category_id' => 1,'id' => 3,
            'eng' => 'How often do you have premature ejaculation (at the very beginning of vaginal penetration)?',
            'rus'=> 'Как часто у вас эякуляция происходит преждевременно (в самом начале вагинального проникновения)?'],

            ['category_id' => 1,'id' => 4,
            'eng' => 'Duration of sexual intercourse (from penetration until ejaculation)?',
            'rus'=> 'Длительность полового акта (от проникновения до момента эякуляции)?'],

            ['category_id' => 1,'id' => 5,
            'eng' => 'Does premature ejaculation occur only when you change your partner?',
            'rus'=> 'Преждевременная эякуляция возникает только при смене партнерши?'],

            ['category_id' => 1,'id' => 6,
            'eng' => 'Do you think that your partner is satisfied with sexual life?',
            'rus'=> 'Считаете ли вы, что ваша партнерша удовлетворена сексуальной жизнью?'],

            ['category_id' => 1,'id' => 7,
            'eng' => 'Do you have before or during intercourse, anxiety, restlessness?',
            'rus'=> 'Испытываете ли вы до  или во время полового акта тревогу, беспокойство?'],

            ['category_id' => 1,'id' => 8,
            'eng' => 'Does it bother you that ejaculation occurs faster than you would like?',
            'rus'=> 'Беспокоит ли вас то, что эякуляция происходит быстрее, чем вы хотели бы?'],

            ['category_id' => 1,'id' => 9,
            'eng' => 'Did premature ejaculan occur in the early stage of your sexual life?',
            'rus'=> 'Преждевременная эякуляция возникла у Вас в самом начале половой жизни?'],

        ];

        Questions::insert($questions);

    }

    private function populateCategory(){

        Category::truncate();

        $categories = [

            ['id'=> 1, 'eng' => 'Premature Ejaculation', 'rus' => 'Преждевременная эякуляция']

        ];

        Category::insert($categories);

    }
}
