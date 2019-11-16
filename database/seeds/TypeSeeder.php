<?php

use Illuminate\Database\Seeder;
use App\Type;

class TypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Type::create([
            'name' => 'вегатерианская'
        ]);

        Type::create([
            'name' => 'острая'
        ]);

        Type::create([
            'name' => 'халяль'
        ]);
    }
}
