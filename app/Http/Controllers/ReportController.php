<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\TransactionItem;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $dari = $request->query('dari', today()->startOfMonth()->toDateString());
        $sampai = $request->query('sampai', today()->toDateString());

        $transactions = Transaction::with('user')
            ->whereDate('created_at', '>=', $dari)
            ->whereDate('created_at', '<=', $sampai)
            ->latest()
            ->get();

        $perProduk = TransactionItem::selectRaw('product_id, SUM(qty) as total_qty, SUM(subtotal) as total_omzet')
            ->whereHas('transaction', function ($query) use ($dari, $sampai) {
                $query->whereDate('created_at', '>=', $dari)
                      ->whereDate('created_at', '<=', $sampai);
            })
            ->groupBy('product_id')
            ->with('product')
            ->orderByDesc('total_qty')
            ->get();

        $omzet = (int) $transactions->sum('total');

        return view('reports.index', compact('dari', 'sampai', 'transactions', 'perProduk', 'omzet'));
    }
}
