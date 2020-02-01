<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            RoleSeeder::class,
            UserSeeder::class,      // TODO: REMOVE IN PRODUCTION
            FlightSeeder::class     // TODO: REMOVE IN PRODUCTION
        ]);
    }
}
