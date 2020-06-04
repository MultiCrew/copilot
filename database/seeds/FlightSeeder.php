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
        FlightRequest::create([
			'requestee_id' => '1',
            'acceptee_id' => '2',
			'departure' => ['EGLL'],
			'arrival' => ['EGPD', 'EGPH', 'EGPF'],
			'aircraft' => 'A320'
		]);
		FlightRequest::create([
			'requestee_id' => '2',
			'departure' => ['EGKK'],
			'arrival' => ['EHAM'],
			'aircraft' => 'A320'
		]);
		FlightRequest::create([
			'requestee_id' => '2',
			'departure' => ['EGHI'],
			'aircraft' => 'DH8D'
		]);
    }
}
