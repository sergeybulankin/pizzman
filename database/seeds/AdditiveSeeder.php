<?php

use Illuminate\Database\Seeder;
use App\Additive;

class AdditiveSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Additive::create([
            'id' => 1,
            'name' => 'Стандарт',
            'price' => 0
        ]);

        factory(Additive::class, 5)->create();
    }
}
