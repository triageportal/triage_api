<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(CountrySeeder::class);
        $this->call(AcssSeeder::class);
        $this->call(DemographicsSeeder::class);
        $this->call(RiskFactorSeeder::class);
        $this->call(PrematureEjaculationSeeder::class);
        $this->call(TriagesSeeder::class);
        $this->call(TriagesDescriptionSeeder::class);
    }
}
