<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        $this->call(AdditiveSeeder::class);
        $this->call(AddressSeeder::class);
        $this->call(FoodAdditiveSeeder::class);
        $this->call(FoodSeeder::class);
        $this->call(FoodTypeSeeder::class);
        $this->call(PizzmanAddressFoodSeeder::class);
        $this->call(PizzmanAddressSeeder::class);
        $this->call(TypeSeeder::class);
        $this->call(TypeOfTimeSeeder::class);
        $this->call(UserSeeder::class);
    }
}
