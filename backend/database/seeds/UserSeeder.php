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
        User::create([
        	'name' 				=>	'daniel vera',
        	'email'				=>	'danielveraangulo703@gmail.com',
        	'password'			=>	'123456'
        ]);
    }
}
