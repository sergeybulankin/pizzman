<?php

use Illuminate\Database\Seeder;
use App\User;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => '89273394968',
            'email' => 'admin@admin.com',
            'password' => bcrypt('12345'),
            'api_token' => str_random(60)
        ]);
    }
}
