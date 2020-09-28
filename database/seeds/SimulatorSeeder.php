<?php

use Illuminate\Database\Seeder;

class SimulatorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Simulator::create(['name' => 'Microsoft Flight Simulator X']);
        Simulator::create(['name' => 'Lockheed Martin Prepar3D v1-3']);
        Simulator::create(['name' => 'Lockheed Martin Prepar3D v4']);
        Simulator::create(['name' => 'Laminar Research X-Plane 10']);
        Simulator::create(['name' => 'Laminar Research X-Plane 11']);
        Simulator::create(['name' => 'Aerofly FS 2']);
        Simulator::create(['name' => 'Microsoft Flight Simulator 2020']);
    }
}
