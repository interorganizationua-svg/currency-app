<?php

namespace App\Console\Commands;

use App\Services\ExchangeRateService;
use Database\Seeders\ExchangeRateSeeder;
use Illuminate\Console\Command;

class SyncRates extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rates:sync {--from=2025-01-01} {--to=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync exchange rates from API';

    /**
     * Execute the console command.
     */
    public function handle(ExchangeRateService $service)
    {
        $from = $this->option('from');
        $to = $this->option('to') ?: null;
        $service->syncRate($from, $to);
        $this->info('Done!!!');
    }
}
