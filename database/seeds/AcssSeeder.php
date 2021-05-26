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

            ['id' => 1,'value' => 0, 'eng' => 'None',
            'rus' => 'Нет'],

            ['id' => 2,'value' => 1, 'eng' => 'Yes, mild',
            'rus' => 'Да, мягкий'],

            ['id' => 3,'value' => 2, 'eng' => 'Yes, moderate',
            'rus' => 'Да, умеренно'],

            ['id' => 4,'value' => 3, 'eng' => 'Yes, severe',
            'rus' => 'Да, суровый'],

            ['id' => 5,'value' => 0, 'eng' => 'No, up to 4 times per day',
            'rus' => 'Нет, до 4 раз в день'],

            ['id' => 6,'value' => 1, 'eng' => 'Yes, mild; 5‐6 times/day',
            'rus' => 'Да, мягкий; 5-6 раз / сут'],

            ['id' => 7,'value' => 2, 'eng' => 'Yes, moderate; 7‐8 times/day',
            'rus' => 'Да, умеренно; 7-8 раз / сут'],

            ['id' => 8,'value' => 3, 'eng' => 'Yes, severe; 9‐10 or more times/day',
            'rus' => 'Да, тяжелый; 9-10 и более раз / день'],

            ['id' => 9,'value' => 0, 'eng' => 'None; (≤99.5˚F)',
            'rus' => 'Нет; (≤37.5˚C)'],

            ['id' => 10,'value' => 1, 'eng' => 'Yes, mild; (99.6˚F-100.2˚F)',
            'rus' => 'Да, мягкий; (37.6˚C-37.8˚C)'],

            ['id' => 11,'value' => 2, 'eng' => 'Yes, moderate; (100.3˚F-102.0˚F)',
            'rus' => 'Да, умеренно; (37.9˚C-38.8˚C)'],

            ['id' => 12,'value' => 3, 'eng' => 'Yes, severe; (≥102.1 ˚F)',
            'rus' => 'Да, тяжелый; (≥38.9 ˚C)'],

            ['id' => 13,'value' => 0, 'eng' => 'Feeling no discomfort (No symptoms at all. I feel as good as usual)',
            'rus' => 'Никакого дискомфорта (Никаких симптомов. Чувствую себя как обычно)'],

            ['id' => 14,'value' => 1, 'eng' => 'Feeling mild discomfort (I feel a somewhat worse than usual)',
            'rus' => 'Ощущение легкого дискомфорта (чувствую себя несколько хуже, чем обычно)'],

            ['id' => 15,'value' => 2, 'eng' => 'Feeling moderate discomfort (I feel quite bad)',
            'rus' => 'Ощущение умеренного дискомфорта (чувствую себя довольно плохо)'],

            ['id' => 16,'value' => 3, 'eng' => 'Feeling severe discomfort (I feel terrible)',
            'rus' => 'Ощущение сильного дискомфорта (ужасно)'],

            ['id' => 17,'value' => 0, 'eng' => 'Not interfered at all (Working as usual on a working day)',
            'rus' => 'Совершенно не мешал (Работал в обычном режиме в рабочий день)'],

            ['id' => 18,'value' => 1, 'eng' => 'Mildly interfered (Working is associated with some discomfort)',
            'rus' => 'Слегка мешает (работа связана с некоторым дискомфортом)'],

            ['id' => 19,'value' => 2, 'eng' => 'Moderately interfered (Daily work requires effort)',
            'rus' => 'Умеренно мешает (ежедневная работа требует усилий)'],

            ['id' => 20,'value' => 3, 'eng' => 'Severely interfered (Usual work or activities are almost impossible)',
            'rus' => 'Сильно воспрепятствовано (обычная работа или деятельность практически невозможны)'],

            ['id' => 21,'value' => 0, 'eng' => 'Not interfered at all (Able to enjoy normal social activities)',
            'rus' => 'Абсолютно не вмешивается (может наслаждаться нормальной общественной деятельностью)'],

            ['id' => 22,'value' => 1, 'eng' => 'Mildly interfered (Less activities than usual)',
            'rus' => 'Слабые помехи (меньше активности, чем обычно)'],

            ['id' => 23,'value' => 2, 'eng' => 'Moderately interfered (Have to spend much time at home)',
            'rus' => 'Умеренно мешает (приходится много времени проводить дома)'],

            ['id' => 24,'value' => 3, 'eng' => 'Severely interfered (Symptoms prevent me from leaving home)',
            'rus' => 'Сильно нарушено (симптомы не позволяют мне выйти из дома)'],

            ['id' => 25,'value' => 0, 'eng' => 'No',
            'rus' => 'Нет'],

            ['id' => 26,'value' => 1, 'eng' => 'Yes',
            'rus' => 'да'],

            ['id' => 27,'value' => 0, 'eng' => 'Yes I feel normal (All symptoms have gone away)',
            'rus' => 'Да, я чувствую себя нормально (все симптомы исчезли)'],

            ['id' => 28,'value' => 1, 'eng' => 'Yes, I feel much better (Most of symptoms have gone away)',
            'rus' => 'Да, чувствую себя намного лучше (большинство симптомов прошло)'],

            ['id' => 29,'value' => 2, 'eng' => 'Yes, I feel somewhat better (Only some symptoms are gone)',
            'rus' => 'Да, мне немного лучше (исчезли только некоторые симптомы)'],

            ['id' => 30,'value' => 3, 'eng' => 'No, there are barely any changes (I still have about the same symptoms)',
            'rus' => 'Нет, изменений практически нет (симптомы у меня примерно те же)'],

            ['id' => 31,'value' => 4, 'eng' => 'Yes, I feel worse (My condition is worse)',
            'rus' => 'Да, мне хуже (состояние хуже)'],

            ['id' => 32,'value' => 0, 'eng' => 'Initial',
            'rus' => 'Первый'],

            ['id' => 33,'value' => 1, 'eng' => 'Follow up',
            'rus' => 'Последующий визит']

        ];

        Response::insert($response);


    }

    private function populateQuestions(){

        Questions::truncate();

        $questions = [

            ['category_id' => 1,'id' => 1,
            'eng' => 'Frequent urination of small amounts of urine (going to the toilet very often)',
            'rus' => 'Частое мочеиспускание с небольшим количеством мочи (очень частое посещение туалета)'],

            ['category_id' => 1,'id' => 2,
            'eng' => 'Urgent urination (a sudden and uncontrollable urge to urinate)',
            'rus' => 'Срочное мочеиспускание (внезапный и неконтролируемый позыв к мочеиспусканию)'],

            ['category_id' => 1,'id' => 3,
            'eng' => 'Feeling burning pain when urinating',
            'rus' => 'Ощущение жгучей боли при мочеиспускании'],

            ['category_id' => 1,'id' => 4,
            'eng' => 'Feeling incomplete bladder emptying (still feel like you could urinate again)',
            'rus' => 'Ощущение неполного опорожнения мочевого пузыря (все еще кажется, что вы снова можете помочиться)'],

            ['category_id' => 1,'id' => 5,
            'eng' => 'Feeling pain not associated with urination in the lower abdomen (below the belly button)',
            'rus' => 'Ощущение боли, не связанной с мочеиспусканием, внизу живота (ниже пупка)'],

            ['category_id' => 1,'id' => 6,
            'eng' => 'Blood seen in urine (without menses)',
            'rus' => 'Кровь в моче (без менструаций)'],

            ['category_id' => 2,'id' => 7,
            'eng' => 'Flank pain (pain in one or both sides of the lower back)',
            'rus' => 'Боль в боку (боль в одной или обеих сторонах поясницы)'],

            ['category_id' => 2,'id' => 8,
            'eng' => 'Abnormal vaginal discharge (amount, color and/or odor)',
            'rus' => 'Аномальные выделения из влагалища (количество, цвет и / или запах)'],

            ['category_id' => 2,'id' => 9,
            'eng' => 'Discharge from the urethra (urinary opening) , without urination',
            'rus' => 'Выделения из уретры (мочеиспускательного канала) без мочеиспускания.'],

            ['category_id' => 2,'id' => 10,
            'eng' => 'Fever/high body temperature',
            'rus' => 'Лихорадка / высокая температура тела'],

            ['category_id' => 3,'id' => 11,
            'eng' => 'Please indicate how much discomfort you have experienced because of your symptoms in the past 24 hours (Mark
            only one answer that suits you best)',
            'rus' => 'Укажите, какой дискомфорт вы испытали из-за своих симптомов за последние 24 часа (отметьте только один ответ, который вам больше всего подходит)'],

            ['category_id' => 3,'id' => 12,
            'eng' => 'Please indicate how your symptoms have interfered with your everyday activities/work in the past 24 hours (Mark only
            one answer that suits you best)',
            'rus' => 'Пожалуйста, укажите, как ваши симптомы мешали вашей повседневной деятельности / работе в течение последних 24 часов (отметьте только один ответ, который вам больше всего подходит)'],

            ['category_id' => 3,'id' => 13,
            'eng' => 'Please indicate how your symptoms have interfered with your social activities (visiting people, meeting with friends,
            etc) in the past 24 hours (Mark only one answer that suits you best)',
            'rus' => 'Укажите, как ваши симптомы повлияли на вашу социальную деятельность (посещение людей, встречи с друзьями и т. Д.) За последние 24 часа (отметьте только один ответ, который вам больше всего подходит)'],

            ['category_id' => 4,'id' => 14,
            'eng' => 'Menstruation (Menses)?',
            'rus' => 'Менструация (менструация)?'],

            ['category_id' => 4,'id' => 15,
            'eng' => 'Premenstrual syndrome (PMS)?',
            'rus' => 'Предменструальный синдром (ПМС)?'],

            ['category_id' => 4,'id' => 16,
            'eng' => 'Signs of menopausal syndrome (e.g. hot flashes)?',
            'rus' => 'Признаки менопаузального синдрома?'],

            ['category_id' => 4,'id' => 17,
            'eng' => 'Pregnancy',
            'rus' => 'Беременность'],

            ['category_id' => 4,'id' => 18,
            'eng' => 'Known (diagnosed) diabetes mellitus (high sugar)',
            'rus' => 'Известный (диагностированный) сахарный диабет.'],

            ['category_id' => 5,'id' => 19,
            'eng' => 'Please indicate if you experienced any changes in your symptoms since the first time you completed this questionnaire?',
            'rus' => 'Пожалуйста, укажите, испытали ли вы какие-либо изменения в ваших симптомах с момента первого заполнения этой анкеты?'],

            ['category_id' => 6,'id' => 20,
            'eng' => 'Please indicate visit type',
            'rus' => 'Укажите тип посещения']
        ];

        Questions::insert($questions);

    }

    private function populateCategory(){

        Category::truncate();

        $categories = [

            ['id'=> 1, 'eng' => 'Typical', 'rus' => 'Типичный'],
            ['id'=> 2,'eng' => 'Differential', 'rus' => 'Дифференциальный'],
            ['id'=> 3,'eng' => 'Quality of life', 'rus' => 'Качество жизни'],
            ['id'=> 4,'eng' => 'Additional', 'rus' => 'Дополнительный'],
            ['id'=> 5,'eng' => 'Dynamics', 'rus' => 'Динамика'],
            ['id'=> 6,'eng' => 'Visit Type', 'rus' => 'Тип посещения']

        ];

        Category::insert($categories);

    }
}
