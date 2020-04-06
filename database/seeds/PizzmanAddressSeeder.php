<?php

use Illuminate\Database\Seeder;
use App\PizzmanAddress;

class PizzmanAddressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PizzmanAddress::create([
            'address_id' => 1
        ]);

        PizzmanAddress::create([
            'address_id' => 2
        ]);

        PizzmanAddress::create([
            'address_id' => 3
        ]);

        PizzmanAddress::create([
            'address_id' => 4
        ]);
    }
}
