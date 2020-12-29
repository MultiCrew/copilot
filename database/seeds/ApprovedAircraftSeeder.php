<?php

use Illuminate\Database\Seeder;
use App\Models\Aircraft\ApprovedAircraft;

class ApprovedAircraftSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ApprovedAircraft::create([
            'icao' => 'B738',
            'name' => 'Zibo 737-800',
            'sim'  => '5',
            'approved' => true
        ]);
        ApprovedAircraft::create([
            'icao' => 'A320',
            'name' => 'FlightFactor A320 Ultimate',
            'sim'  => '5',
            'approved' => true
        ]);
        ApprovedAircraft::create([
            'icao' => 'A318',
            'name' => 'Aerosoft Airbus A318 Professional',
            'sim'  => '3',
            'approved' => true
        ]);
        ApprovedAircraft::create([
            'icao' => 'A319',
            'name' => 'Aerosoft Airbus A319 Professional',
            'sim'  => '3',
            'approved' => true
        ]);
        ApprovedAircraft::create([
            'icao' => 'A320',
            'name' => 'Aerosoft Airbus A320 Professional',
            'sim'  => '3',
            'approved' => true
        ]);
        ApprovedAircraft::create([
            'icao' => 'A321',
            'name' => 'Aerosoft Airbus A321 Professional',
            'sim'  => '3',
            'approved' => true
        ]);
        ApprovedAircraft::create([
            'icao' => 'A318',
            'name' => 'Aerosoft Airbus A318',
            'sim'  => '2',
            'approved' => true
        ]);
        ApprovedAircraft::create([
            'icao' => 'A319',
            'name' => 'Aerosoft Airbus A319',
            'sim'  => '2',
            'approved' => true
        ]);
        ApprovedAircraft::create([
            'icao' => 'A320',
            'name' => 'Aerosoft Airbus A320',
            'sim'  => '2',
            'approved' => true
        ]);
        ApprovedAircraft::create([
            'icao' => 'A321',
            'name' => 'Aerosoft Airbus A321',
            'sim'  => '2',
            'approved' => true
        ]);
        ApprovedAircraft::create([
            'icao' => 'A318',
            'name' => 'Aerosoft Airbus A318',
            'sim'  => '1',
            'approved' => true
        ]);
        ApprovedAircraft::create([
            'icao' => 'A319',
            'name' => 'Aerosoft Airbus A319',
            'sim'  => '1',
            'approved' => true
        ]);
        ApprovedAircraft::create([
            'icao' => 'A320',
            'name' => 'Aerosoft Airbus A320',
            'sim'  => '1',
            'approved' => true
        ]);
        ApprovedAircraft::create([
            'icao' => 'A321',
            'name' => 'Aerosoft Airbus A321',
            'sim'  => '1',
            'approved' => true
        ]);
        ApprovedAircraft::create([
            'icao' => 'DH8D',
            'name' => 'Majestic Dash 8 Q400 Pro Edition',
            'sim'  => '3',
            'approved' => true
        ]);
        ApprovedAircraft::create([
            'icao' => 'DH8D',
            'name' => 'Majestic Dash 8 Q400 Pro Edition',
            'sim'  => '1',
            'approved' => true
        ]);
    }
}
