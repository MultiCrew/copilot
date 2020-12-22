<?php

namespace App\Console\Commands;

use App\Imports\CountryImport;
use Illuminate\Console\Command;

class CountryDatabaseImport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:country';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import all Countries into the database';

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
        $data = file_get_contents('https://ourairports.com/data/countries.csv');
        file_put_contents('countries.csv', $data);
        (new CountryImport)->withOutput($this->output)->import('countries.csv', null, \Maatwebsite\Excel\Excel::CSV);
        unlink('countries.csv');
        $this->output->success('Import successful');
    }
}
