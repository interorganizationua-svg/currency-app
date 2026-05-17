<?php

namespace App\Http\Controllers;

use App\Models\Currency;
use App\Services\ExchangeRateService;

class HomeController extends Controller
{
    public function __construct(private ExchangeRateService $service) {}

    public function index()
    {
        if (!$this->service->hasRate()) {
            $this->service->syncToday();
        }

        $currencies = Currency::where('is_active', 1)->get();

        return view('home', compact('currencies'));
    }
}