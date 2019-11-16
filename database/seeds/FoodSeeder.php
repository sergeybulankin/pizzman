<?php

use Illuminate\Database\Seeder;
use App\Food;

class FoodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Food::class, 10)->create();
    }
}
