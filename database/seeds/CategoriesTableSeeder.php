<?php

use App\Category as AppCategory;
use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        AppCategory::create(
            [
                'name' => 'elektronik',
            ],
            [
                'name' => 'pakaian'
            ],
            [
                'name' => 'furniture'
            ]
        );
    }
}
