<?php

namespace App\Console\Commands;

use App\Imports\AircraftImport;
use Illuminate\Console\Command;

class AircraftDatabaseImport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:aircraft';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import all Aircraft into the database';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->output->title('Starting import');
        $data = file_get_contents('https://raw.githubusercontent.com/jpatokal/openflights/master/data/planes.dat');
        file_put_contents('aircraft.csv', $data);
        (new AircraftImport)->withOutput($this->output)->import('aircraft.csv', null, \Maatwebsite\Excel\Excel::CSV);
        unlink('aircraft.csv');
        $this->output->success('Import successful');
    }
}
