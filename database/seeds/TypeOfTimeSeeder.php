<?php

use Illuminate\Database\Seeder;
use App\TypeOfTime;

class TypeOfTimeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TypeOfTime::create([
            'type' => 0
        ]);

        TypeOfTime::create([
            'type' => 1
        ]);
    }
}
