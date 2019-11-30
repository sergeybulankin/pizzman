<?php

use Illuminate\Database\Seeder;
use App\Status;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Status::create([
            'name' => 'Обрабатывается'
        ]);

        Status::create([
            'name' => 'Рассматривается'
        ]);

        Status::create([
            'name' => 'Принят'
        ]);

        Status::create([
            'name' => 'Готовится'
        ]);

        Status::create([
            'name' => 'В пути'
        ]);

        Status::create([
            'name' => 'Доставлено'
        ]);
    }
}
