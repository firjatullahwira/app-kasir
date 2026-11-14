@extends('layouts.app')

@section('title', 'Struk '.$transaction->kode_transaksi)

@section('content')
    <h1>Struk Transaksi</h1>

    <p class="no-print">
        <a href="{{ route('transactions.create') }}" class="btn">+ Transaksi Baru</a>
        <button type="button" class="btn btn-gray" onclick="window.print()">Cetak</button>
        <a href="{{ route('transactions.index') }}">Riwayat</a>
    </p>

    <p>
        Kode: <strong>{{ $transaction->kode_transaksi }}</strong><br>
        Tanggal: {{ $transaction->created_at->format('d-m-Y H:i') }}<br>
        Kasir: {{ $transaction->user->name }}
    </p>

    <table>
        <thead>
            <tr>
                <th>Produk</th>
                <th class="right">Harga</th>
                <th class="right">Qty</th>
                <th class="right">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($transaction->items as $item)
                <tr>
                    <td>{{ $item->product->nama }}</td>
                    <td class="right">Rp {{ number_format($item->harga, 0, ',', '.') }}</td>
                    <td class="right">{{ $item->qty }}</td>
                    <td class="right">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th colspan="3" class="right">Total</th>
                <th class="right">Rp {{ number_format($transaction->total, 0, ',', '.') }}</th>
            </tr>
            <tr>
                <td colspan="3" class="right">Bayar</td>
                <td class="right">Rp {{ number_format($transaction->bayar, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td colspan="3" class="right">Kembalian</td>
                <td class="right">Rp {{ number_format($transaction->kembalian, 0, ',', '.') }}</td>
            </tr>
        </tfoot>
    </table>
@endsection
