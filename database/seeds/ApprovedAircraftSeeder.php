<?php

use Illuminate\Database\Seeder;

class ApprovedAircraftSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('approved_aircraft')->insert([
            'icao' => 'B738',
            'name' => 'Zibo 737-800',
            'sim'  => 'xp1',
            'approved' => true
        ]);
        DB::table('approved_aircraft')->insert([
            'icao' => 'A320',
            'name' => 'FlightFactor A320 Ultimate',
            'sim'  => 'xp1',
            'approved' => true
        ]);
        DB::table('approved_aircraft')->insert([
            'icao' => 'A318',
            'name' => 'Aerosoft Airbus A318 Professional',
            'sim'  => 'p4d',
            'approved' => true
        ]);
        DB::table('approved_aircraft')->insert([
            'icao' => 'A319',
            'name' => 'Aerosoft Airbus A319 Professional',
            'sim'  => 'p4d',
            'approved' => true
        ]);
        DB::table('approved_aircraft')->insert([
            'icao' => 'A320',
            'name' => 'Aerosoft Airbus A320 Professional',
            'sim'  => 'p4d',
            'approved' => true
        ]);
        DB::table('approved_aircraft')->insert([
            'icao' => 'A321',
            'name' => 'Aerosoft Airbus A321 Professional',
            'sim'  => 'p4d',
            'approved' => true
        ]);
        DB::table('approved_aircraft')->insert([
            'icao' => 'A318',
            'name' => 'Aerosoft Airbus A318',
            'sim'  => 'p3d',
            'approved' => true
        ]);
        DB::table('approved_aircraft')->insert([
            'icao' => 'A319',
            'name' => 'Aerosoft Airbus A319',
            'sim'  => 'p3d',
            'approved' => true
        ]);
        DB::table('approved_aircraft')->insert([
            'icao' => 'A320',
            'name' => 'Aerosoft Airbus A320',
            'sim'  => 'p3d',
            'approved' => true
        ]);
        DB::table('approved_aircraft')->insert([
            'icao' => 'A321',
            'name' => 'Aerosoft Airbus A321',
            'sim'  => 'p3d',
            'approved' => true
        ]);
        DB::table('approved_aircraft')->insert([
            'icao' => 'A318',
            'name' => 'Aerosoft Airbus A318',
            'sim'  => 'fsx',
            'approved' => true
        ]);
        DB::table('approved_aircraft')->insert([
            'icao' => 'A319',
            'name' => 'Aerosoft Airbus A319',
            'sim'  => 'fsx',
            'approved' => true
        ]);
        DB::table('approved_aircraft')->insert([
            'icao' => 'A320',
            'name' => 'Aerosoft Airbus A320',
            'sim'  => 'fsx',
            'approved' => true
        ]);
        DB::table('approved_aircraft')->insert([
            'icao' => 'A321',
            'name' => 'Aerosoft Airbus A321',
            'sim'  => 'fsx',
            'approved' => true
        ]);
        DB::table('approved_aircraft')->insert([
            'icao' => 'DH8D',
            'name' => 'Majestic Dash 8 Q400 Pro Edition',
            'sim'  => 'p4d',
            'approved' => true
        ]);
        DB::table('approved_aircraft')->insert([
            'icao' => 'DH8D',
            'name' => 'Majestic Dash 8 Q400 Pro Edition',
            'sim'  => 'fsx',
            'approved' => true
        ]);
    }
}
