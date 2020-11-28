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
            'name' => 'adminaa',
            'email' => 'adminaa@gmail.com',
            'password' => bcrypt('admin'),
            'kode' => 'admin',
        ]);
    }
}
