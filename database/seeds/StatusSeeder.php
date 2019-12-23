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
            'name' => 'Обрабатывается',
            'description' => 'Заказ еще не утвержден'
        ]);

        Status::create([
            'name' => 'Рассматривается',
            'description' => 'Сейчам мы принимаем заявку и раскидываем её по поварам'
        ]);

        Status::create([
            'name' => 'Принят',
            'description' => 'Заказ принят'
        ]);

        Status::create([
            'name' => 'Готовится',
            'description' => 'Мы уже готовим Вам вкуснейшие блюда'
        ]);

        Status::create([
            'name' => 'В пути',
            'description' => 'Мы уже мчим к указанной вам точке с заказами. Ждите в ближайшие минуты'
        ]);

        Status::create([
            'name' => 'Доставлено',
            'description' => 'Приятного аппетита!'
        ]);
    }
}
