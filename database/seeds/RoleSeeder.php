<?php

use Illuminate\Database\Seeder;
use App\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create([
            'name' => 'Пользователь',
        ]);

        Role::create([
            'name' => 'Админ',
        ]);

        Role::create([
            'name' => 'Водитель',
        ]);

        Role::create([
            'name' => 'Суперадмин',
        ]);
    }
}
