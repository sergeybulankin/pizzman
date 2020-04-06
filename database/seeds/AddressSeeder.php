<?php

use Illuminate\Database\Seeder;
use App\Address;

class AddressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Address::create([
            'address' => 'Стерлитамак, Ленина, 29а',
            'kv' => 0,
            'coordinates' => 0
        ]);

        Address::create([
            'address' => 'Стерлитамак, Худайбердина, 22',
            'kv' => 0,
            'coordinates' => 0,
        ]);

        Address::create([
            'address' => 'Стерлитамак, Мира, 1б',
            'kv' => 0,
            'coordinates' => 0,
        ]);

        Address::create([
            'address' => 'Стерлитамак, Артема, 143',
            'kv' => 0,
            'coordinates' => 0,
        ]);
    }
}
