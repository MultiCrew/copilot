<?php

namespace App\Jobs;

use App\Models\Aircraft\Aircraft;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class AircraftDatabaseUpdate implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        $data = 'https://raw.githubusercontent.com/jpatokal/openflights/master/data/planes.dat';
        $fileData = fopen($data, 'r');
        while(($line = fgetcsv($fileData)) !== false) {
            $s[] = $line;
        }
        for($i = 1; $i < count($s); $i++) {
            if(Aircraft::where('icao', $s[$i][2])->exists()) continue;
            $airport = new Aircraft(); 
            $airport->icao = $s[$i][2];
            $airport->iata = $s[$i][1];
            $airport->name = $s[$i][0];
            $airport->save();
        }
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
    }
}
