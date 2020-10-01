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
            ApprovedAircraftSeeder::class,
            SimulatorSeeder::class
        ]);

        if (App::environment('local')) {
            $this->call([
                UserSeeder::class,
                FlightSeeder::class
            ]);
        }
    }
}
