<?php

use Illuminate\Database\Seeder;
use App\User; 
//jangan lupa impor sebelom seeder

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'surti',
            'email' => 'surti@gmail.com',
            'password' => bcrypt('123123'),
            'kode' => '123',
        ]);
    }
}
