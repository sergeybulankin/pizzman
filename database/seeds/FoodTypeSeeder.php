<?php

use Illuminate\Database\Seeder;
use App\FoodType;

class FoodTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(FoodType::class, 10)->create();
    }
}
