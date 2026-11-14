<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Transaction;

class StatsController extends Controller
{
    public function index()
    {
        return response()->json([
            'total_produk' => Product::count(),
            'transaksi_hari_ini' => Transaction::whereDate('created_at', today())->count(),
            'omzet_hari_ini' => (int) Transaction::whereDate('created_at', today())->sum('total'),
        ]);
    }
}
