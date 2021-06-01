<?php

use Illuminate\Database\Seeder;
use App\Triages;

class TriagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Triages::truncate();

        $triages = [

            ['triage_id'=> 1, 'triage' => 'acss', 'eng' => 'Acute Cystitis Symptom Score', 'rus'=>'Оценка симптомов острого цистита'],
            ['triage_id'=> 2, 'triage' => 'premature_ejaculation', 'eng' => 'Premature Ejaculation', 'rus'=>'Преждевременная эякуляция'],
            ['triage_id'=> 3, 'triage' => 'vitals', 'eng' => 'Vitals', 'rus'=>'Жизненные показатели']

        ];

        Triages::insert($triages);
    }
}
