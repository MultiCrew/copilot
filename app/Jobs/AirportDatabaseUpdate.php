<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use App\Models\Airports\Airport;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class AirportDatabaseUpdate implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $data = 'http://ourairports.com/data/airports.csv';
        $fileData = fopen($data, 'r');
        while(($line = fgetcsv($fileData)) !== false) {
            $s[] = $line;
        }
        for($i = 1; $i < count($s); $i++) {
            if(Airport::where('icao', $s[$i][1])->exists()) continue;
            if($s[$i][2] == 'heliport' || $s[$i][2] == 'closed_airport') continue;
            $airport = new Airport(); 
            $airport->icao = $s[$i][1];
            $airport->name = $s[$i][3];
            $airport->latitude = $s[$i][4];
            $airport->longitude = $s[$i][5];
            if($s[$i][6] != '') $airport->elevation = $s[$i][6];
            $airport->save();
        }
    }
}
