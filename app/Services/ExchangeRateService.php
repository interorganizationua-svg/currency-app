<?php 


namespace App\Services;

use App\Models\Currency;
use App\Models\ExchangeRate;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class ExchangeRateService {
    private string $baseUrl;
    public function __construct() {
        ## дістаємо з апі frankfurter
        $this->baseUrl = config('services.exchange_api.url', 'https://api.frankfurter.dev/v2');;
    }

    public function syncRate(string $from = '2025-01-01', ?string $to = null): void {
        set_time_limit(0);
        $to = $to ?? Carbon::today()->toDateString();

        $startDate = Carbon::parse($from);
        $endDate = Carbon::parse($to);

        
        for ($date = $startDate->copy(); $date->lte($endDate); $date->addDay()) {
            
                $dateStr = $date->toDateString();

                ## запит
                $res = Http::get("{$this->baseUrl}/rates", [ 
                    'base'=> 'USD',
                    'date'=> $dateStr,
                ]);

                ## звичайна перевірка
                if (!$res->successful()) {
                    Log::error('Failed to fetch exchange rates from the api');
                    return;
                }

                $data = $res->json();
            

                ##  бакс рівняємо до 1.0
                $usd = Currency::where('code', 'USD')->first();
                if ($usd) {
                        ExchangeRate::updateOrCreate(
                            [
                            'date' => $dateStr,
                            'currency_id' => $usd->id,
                            'base_currency' => 'USD',
                            ], 
                            ['rate' => 1.0]
                        );

                }

                ## перебір курсів + збереження в базу
                foreach ($data as $items) {
                        $currency = Currency::where('code', $items['quote'])->first();
                        
                        ## якшо нема такої валюті, пропускаєм
                        if (!$currency) continue;
                        ExchangeRate::updateOrCreate(
                            [
                            'date' => $items['date'],
                            'currency_id' => $currency->id,
                            'base_currency' => 'USD',
                            ], 
                            ['rate' => $items['rate']]
                        );
                    ##  unsleep(1000); для теста не потрібно
                }
            };
            
        }   
        
        ## синхронізація за день
        public function syncToday(): void {
            $today = Carbon::today()->toDateString();
            $this->syncRate($today, $today);
        }
        ## перевірка наявності курсу за сьогодні в базі 
        public function hasRate(): bool {
            return ExchangeRate::whereDate('date', Carbon::today())->exists();
        }
    
}  
?>