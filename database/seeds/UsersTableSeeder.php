<?php

use App\User;
use Illuminate\Database\Seeder;

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

            'usuario' => 'admin',
            'password' => bcrypt('secret'),
            'remember_token' => str_random(10),
            'condicion' => 1,
            'idrol' => 1,
        ]);

 
    }
}
