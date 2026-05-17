<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Currency;
use Illuminate\Database\Seeder;

class CurrencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $currencies  = [
            ['code' => 'USD','name'=> 'Dollar', 'is_active' => 1],
            ['code' => 'EUR', 'name'=> 'Euro', 'is_active' => 1],
            ['code' => 'GBP', 'name'=> 'British Pound', 'is_active' => 1],
            ['code' => 'UAH', 'name'=> 'Hrivna', 'is_active' => 1],
        ];
        foreach ($currencies as $currency) {
            Currency::updateOrCreate(['code' => $currency['code']] ,$currency);
        }
    }
}
