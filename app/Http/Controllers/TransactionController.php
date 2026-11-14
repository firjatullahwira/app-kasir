<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $transactions = Transaction::with('user')
            ->when($request->query('tanggal'), fn ($query, $tanggal) => $query->whereDate('created_at', $tanggal))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('transactions.index', compact('transactions'));
    }

    public function create()
    {
        $products = Product::where('stok', '>', 0)->orderBy('nama')->get();

        return view('transactions.create', compact('products'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'items' => 'required|array',
            'items.*' => 'nullable|integer|min:0',
            'bayar' => 'required|integer|min:0',
        ], [
            'items.required' => 'Pilih minimal satu produk.',
            'items.*.integer' => 'Jumlah produk harus berupa angka bulat.',
            'items.*.min' => 'Jumlah produk tidak boleh negatif.',
            'bayar.required' => 'Uang bayar wajib diisi.',
            'bayar.integer' => 'Uang bayar harus berupa angka.',
        ]);

        // Ambil hanya produk yang jumlahnya > 0. Key = id produk, value = qty.
        $items = collect($validated['items'])
            ->map(fn ($qty) => (int) $qty)
            ->filter(fn ($qty) => $qty > 0);

        if ($items->isEmpty()) {
            throw ValidationException::withMessages([
                'items' => 'Pilih minimal satu produk dengan jumlah lebih dari 0.',
            ]);
        }

        $bayar = (int) $validated['bayar'];

        $transaction = DB::transaction(function () use ($items, $bayar) {
            // Kunci baris produk agar stok tidak ditimpa kasir lain pada saat yang sama
            $products = Product::whereIn('id', $items->keys())
                ->lockForUpdate()
                ->get()
                ->keyBy('id');

            $total = 0;
            $rows = [];

            foreach ($items as $productId => $qty) {
                $product = $products->get($productId);

                if (! $product) {
                    throw ValidationException::withMessages([
                        'items' => 'Ada produk yang tidak ditemukan.',
                    ]);
                }

                if ($product->stok < $qty) {
                    throw ValidationException::withMessages([
                        'items' => "Stok {$product->nama} tidak cukup (sisa {$product->stok}).",
                    ]);
                }

                $subtotal = $product->harga * $qty;
                $total += $subtotal;

                $rows[] = [
                    'product_id' => $product->id,
                    'qty' => $qty,
                    'harga' => $product->harga,
                    'subtotal' => $subtotal,
                ];
            }

            if ($bayar < $total) {
                throw ValidationException::withMessages([
                    'bayar' => 'Uang bayar kurang dari total belanja.',
                ]);
            }

            $transaction = Transaction::create([
                'kode_transaksi' => 'TRX-'.now()->format('ymdHis').Str::upper(Str::random(3)),
                'user_id' => auth()->id(),
                'total' => $total,
                'bayar' => $bayar,
                'kembalian' => $bayar - $total,
            ]);

            foreach ($rows as $row) {
                $transaction->items()->create($row);
                $products[$row['product_id']]->decrement('stok', $row['qty']);
            }

            return $transaction;
        });

        return redirect()->route('transactions.show', $transaction)
            ->with('success', 'Transaksi berhasil disimpan.');
    }

    public function show(Transaction $transaction)
    {
        $transaction->load('user', 'items.product');

        return view('transactions.show', compact('transaction'));
    }
}
