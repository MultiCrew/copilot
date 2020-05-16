<?php

namespace App\Console\Commands;

use App\Imports\AirportImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Console\Command;

class AirportDatabaseImport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:airport';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import all Airports into the database';

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
        $data = file_get_contents('http://ourairports.com/data/airports.csv');
        file_put_contents('airport.csv', $data);
        (new AirportImport)->withOutput($this->output)->import('airport.csv', null, \Maatwebsite\Excel\Excel::CSV);
        unlink('airport.csv');
        $this->output->success('Import successful');
    }
}
