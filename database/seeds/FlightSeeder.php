<?php

use Illuminate\Database\Seeder;

class FlightSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('flight_requests')->insert([
			'user_id' => '1',
			'departure' => 'EGLL',
			'arrival' => 'EGPD',
			'aircraft' => 'A320'
		]);
		DB::table('flight_requests')->insert([
			'user_id' => '1',
			'departure' => 'EGKK',
			'arrival' => 'EHAM',
			'aircraft' => 'A320'
		]);
		DB::table('flight_requests')->insert([
			'user_id' => '1',
			'departure' => 'EGHI',
			'arrival' => 'EHAM',
			'aircraft' => 'DH8D'
		]);
    }
}
