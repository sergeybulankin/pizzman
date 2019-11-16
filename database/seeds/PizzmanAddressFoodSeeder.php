<?php

use Illuminate\Database\Seeder;
use App\PizzmanAddressFood;

class PizzmanAddressFoodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(PizzmanAddressFood::class, 10)->create();
    }
}
