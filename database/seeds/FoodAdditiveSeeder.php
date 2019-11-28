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
        for ($i=1; $i<=10; $i++) {
            FoodAdditive::create([
                'food_id' => $i,
                'additive_id' => 1
            ]);
        }

        factory(FoodAdditive::class, 10)->create();
    }
}
