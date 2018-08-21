<?php

use Illuminate\Database\Seeder;
use App\User;

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
            'name' => 'Francisco Oliveira',
            'email' => 'admin@mail.com',
            'password' => bcrypt('123456')
        ]);

        User::create([
            'name' => 'usuario teste',
            'email' => 'teste@mail.com',
            'password' => bcrypt('123123')
        ]);

    }
}
