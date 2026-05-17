<?php

namespace App\Console\Commands;

use App\Services\ExchangeRateService;
use Illuminate\Console\Command;
use Carbon\Carbon;

class SyncExchangeRates extends Command
{
    protected $signature = "rates:sync {--history : Sync last 7 days}";
    protected $description = "Sync exchange rates from API";

    public function __construct(private ExchangeRateService $service)
    {
        parent::__construct();
    }
    public function handle()
    {
        if ($this->option("history")) {
            $from = Carbon::today()->subDays(7)->toDateString();
            $this->info("Sync last 7 days---");
            $this->service->syncRate($from);
        } else {
            $this->info("Sync today---");
            $this->service->syncToday();
        }
        $this->info("Done!!!");
    }


}
