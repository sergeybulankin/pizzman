<?php

use Illuminate\Database\Seeder;
use App\FoodAdditive;

class FoodAdditiveSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(FoodAdditive::class, 10)->create();
    }
}
