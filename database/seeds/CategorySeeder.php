<?php

use Illuminate\Database\Seeder;
use App\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::create([
            'name' => 'Пицца',
            'icon' => ''
        ]);

        Category::create([
            'name' => 'Выпечка',
            'icon' => ''
        ]);

        Category::create([
            'name' => 'Десерты',
            'icon' => ''
        ]);

        Category::create([
            'name' => 'Напитки',
            'icon' => ''
        ]);
    }
}
