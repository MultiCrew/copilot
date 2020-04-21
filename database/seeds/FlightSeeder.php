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
        DB::table('flights')->insert([
			'requestee_id' => '1',
            'acceptee_id' => '2',
			'departure' => 'EGLL',
			'arrival' => 'EGPD',
			'aircraft' => 'A320'
		]);
		DB::table('flights')->insert([
			'requestee_id' => '2',
			'departure' => 'EGKK',
			'arrival' => 'EHAM',
			'aircraft' => 'A320'
		]);
		DB::table('flights')->insert([
			'requestee_id' => '2',
			'departure' => 'EGHI',
			'arrival' => 'EHAM',
			'aircraft' => 'DH8D'
		]);
    }
}
