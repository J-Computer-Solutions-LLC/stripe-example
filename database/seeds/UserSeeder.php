<?php

use Illuminate\Database\Seeder;
use App\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::Create([
          'name' => 'Dillon',
          'email' => 'green.koopa667@gmail.com',
          'password' => bcrypt('Ironman667')
        ]);
    }
}
