<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Currency;
use App\Models\ExchangeRate;
use Illuminate\Http\Request;

class ExchangeRateController extends Controller
{
    public function index(Request $request)
    {
        $rates = ExchangeRate::with('currency')
            ->when($request->currency, function ($q) use ($request) {
                $currency = Currency::where('code', $request->currency)->first();
                if ($currency) $q->where('currency_id', $currency->id);
            })
            ->orderBy('date', 'desc')
            ->limit(50)
            ->get();

        return response()->json($rates);
    }

    public function chart(Request $request)
    {
        $days = $request->get('days', 7);
        $currencyCode = $request->get('currency', 'EUR');

        $currency = Currency::where('code', $currencyCode)->first();

        ## Currency not found 404
        if (!$currency) {
            return response()->json(['error' => 'Currency not found'], 404);
        }

        $rates = ExchangeRate::where('currency_id', $currency->id)
            ->when($days !== 'all', function ($q) use ($days) {
                $q->where('date', '>=', now()->subDays((int)$days)->toDateString());
            })
            ->orderBy('date')
            ->get(['date', 'rate']);

        
        ## handler of empty data 
        $filed = collect();
        $statDate = now()->subDays($days === 'all' ?'365': (int)$days);

        $endDate = now();
        $lastRate = $rates->first()->rate ?? 0;

        for ($date = $statDate->copy(); $date->lte($endDate); $date->addDay()) {
            $searchDate =  $rates->firstWhere('date', $date->toDateString());

            if ($searchDate) { 
             $lastRate = $searchDate->rate;
             $filed->push($searchDate);
            } else {
                 $filed->push([
                    'date'=> $date->toDateString(),
                    'rate'=> $lastRate,
                 ]);
            }
        }


        return response()->json([
            'currency' => $currencyCode,
            'days'     => $days,
            'data'     => $filed,
        ]);
    }
}