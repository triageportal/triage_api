<?php

use Illuminate\Database\Seeder;
use App\TriagesDescription; 

class TriagesDescriptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TriagesDescription::truncate();

        $description = [

            ['triage_id'=> 1,
            'eng' => 'The Acute Cystitis Symptom Score (ACSS) is as a self-reporting questionnaire for clinical diagnosis of acute uncomplicated cystitis (AUC) and symptomatic changes in female patients.', 
            'rus'=>'Оценка симптомов острого цистита представляет собой опросник для самостоятельной регистрации клинической диагностики острого неосложненного цистита (AUC) и симптоматических изменений у пациентов женского пола.'],

            ['triage_id'=> 2, 
            'eng' => 'The Index of Premature Ejaculation is a reliable and valid questionnaire for the assessment of control over ejaculation, satisfaction with sex life, and distress in men with PE.', 
            'rus'=>'Индекс преждевременной эякуляции - это надежный и действенный опросник для оценки контроля над эякуляцией, удовлетворенности сексуальной жизнью и дистресса у мужчин с ПЭ.'],

            ['triage_id'=> 3, 
            'eng' => 'Vital Signs are the body’s most commonly used measurements. That is because they provide useful information about the patient’s clinical condition and are easy (and fast) to obtain. ', 
            'rus'=>'Жизненные показатели - это наиболее часто используемые параметры тела. Это потому, что они предоставляют полезную информацию о клиническом состоянии пациента и их легко (и быстро) получить.']

        ];

        TriagesDescription::insert($description);
    }
}
