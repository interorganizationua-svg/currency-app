<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\ExchangeRateService;
use Illuminate\Http\Request;

class AdminController extends Controller {

    public function index() {
        return view('admin.index');  
        }
    public function sync(Request $request, ExchangeRateService $service) {
        
    
        $from = $request->get('from', now()->subDays(7)-> toDateString());
        $to = $request->get('to', now()->subDays());
        $service->syncRate($from, $to);
        return redirect()->back()->with('success','done!!!');
    }
}


?>