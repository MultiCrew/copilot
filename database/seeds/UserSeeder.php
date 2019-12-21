<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Test User',
            'username' => 'testuser',
            'email' => 'test@multicrew.co.uk',
            'password' => Hash::make('test')
        ]);
    }
}
