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
            'sim'  => 'X-Plane 11',
            'approved' => true
        ]);
        DB::table('approved_aircraft')->insert([
            'icao' => 'A320',
            'name' => 'FlightFactor A320 Ultimate',
            'sim'  => 'X-Plane 11',
            'approved' => true
        ]);
        DB::table('approved_aircraft')->insert([
            'icao' => 'A318',
            'name' => 'Aerosoft Airbus A318 Professional',
            'sim'  => 'P3D v4',
            'approved' => true
        ]);
        DB::table('approved_aircraft')->insert([
            'icao' => 'A319',
            'name' => 'Aerosoft Airbus A319 Professional',
            'sim'  => 'P3D v4',
            'approved' => true
        ]);
        DB::table('approved_aircraft')->insert([
            'icao' => 'A320',
            'name' => 'Aerosoft Airbus A320 Professional',
            'sim'  => 'P3D v4',
            'approved' => true
        ]);
        DB::table('approved_aircraft')->insert([
            'icao' => 'A321',
            'name' => 'Aerosoft Airbus A321 Professional',
            'sim'  => 'P3D v4',
            'approved' => true
        ]);
        DB::table('approved_aircraft')->insert([
            'icao' => 'A318',
            'name' => 'Aerosoft Airbus A318',
            'sim'  => 'P3D v3',
            'approved' => true
        ]);
        DB::table('approved_aircraft')->insert([
            'icao' => 'A319',
            'name' => 'Aerosoft Airbus A319',
            'sim'  => 'P3D v3',
            'approved' => true
        ]);
        DB::table('approved_aircraft')->insert([
            'icao' => 'A320',
            'name' => 'Aerosoft Airbus A320',
            'sim'  => 'P3D v3',
            'approved' => true
        ]);
        DB::table('approved_aircraft')->insert([
            'icao' => 'A321',
            'name' => 'Aerosoft Airbus A321',
            'sim'  => 'P3D v3',
            'approved' => true
        ]);
        DB::table('approved_aircraft')->insert([
            'icao' => 'A318',
            'name' => 'Aerosoft Airbus A318',
            'sim'  => 'FSX',
            'approved' => true
        ]);
        DB::table('approved_aircraft')->insert([
            'icao' => 'A319',
            'name' => 'Aerosoft Airbus A319',
            'sim'  => 'FSX',
            'approved' => true
        ]);
        DB::table('approved_aircraft')->insert([
            'icao' => 'A320',
            'name' => 'Aerosoft Airbus A320',
            'sim'  => 'FSX',
            'approved' => true
        ]);
        DB::table('approved_aircraft')->insert([
            'icao' => 'A321',
            'name' => 'Aerosoft Airbus A321',
            'sim'  => 'FSX',
            'approved' => true
        ]);
        DB::table('approved_aircraft')->insert([
            'icao' => 'DH8D',
            'name' => 'Majestic Dash 8 Q400 Pro Edition',
            'sim'  => 'P3D v4',
            'approved' => true
        ]);
        DB::table('approved_aircraft')->insert([
            'icao' => 'DH8D',
            'name' => 'Majestic Dash 8 Q400 Pro Edition',
            'sim'  => 'FSX',
            'approved' => true
        ]);
    }
}
