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
        factory(Additive::class, 5)->create();
    }
}
