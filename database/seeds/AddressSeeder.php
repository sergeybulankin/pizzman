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
            'address' => 'Стерлитамак, Ленина, 25',
            'kv' => 0,
            'coordinates' => 0
        ]);

        Address::create([
            'address' => 'Стерлитамак, Худайбердина, 12',
            'kv' => 0,
            'coordinates' => 0,
        ]);
    }
}
