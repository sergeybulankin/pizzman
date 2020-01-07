<?php

use Illuminate\Database\Seeder;
use App\User;
use App\UserRole;
use App\Account;
use App\UserPoint;

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

        UserRole::create([
            'user_id' => 1,
            'role_id' => 4
        ]);

        Account::create([
            'user_id' => 1,
            'link' => '',
            'name' => 'Сергей',
            'second_name' => 'Буланкин'
        ]);

        UserPoint::create([
            'user_id' => 1,
            'pizzman_address_id' => rand(1, 2)
        ]);
    }
}
