<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Transaction;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_produk' => Product::count(),
            'stok_menipis' => Product::where('stok', '<=', 5)->count(),
            'transaksi_hari_ini' => Transaction::whereDate('created_at', today())->count(),
            'omzet_hari_ini' => (int) Transaction::whereDate('created_at', today())->sum('total'),
        ];

        $stokMenipis = Product::where('stok', '<=', 5)->orderBy('stok')->take(5)->get();
        $terbaru = Transaction::with('user')->latest()->take(5)->get();

        return view('dashboard', compact('stats', 'stokMenipis', 'terbaru'));
    }
}
