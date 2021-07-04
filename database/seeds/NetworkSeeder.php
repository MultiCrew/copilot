<?php

use Illuminate\Database\Seeder;

class NetworkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Network::create(['name' => 'VATSIM']);
        Network::create(['name' => 'IVAO']);
        Network::create(['name' => 'POSCON']);
        Network::create(['name' => 'Multiplayer']);
    }
}
