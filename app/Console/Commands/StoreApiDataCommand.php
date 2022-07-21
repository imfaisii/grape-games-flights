<?php

namespace App\Console\Commands;

use App\Services\FlightApiService;
use Illuminate\Console\Command;

class StoreApiDataCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'flight:api-store';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command fetched stores the flight data everday.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // execute business logic
        FlightApiService::execute();

        $this->info("Done");
        return 0;
    }
}
