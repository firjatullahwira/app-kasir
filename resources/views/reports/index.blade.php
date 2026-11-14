@extends('layouts.app')

@section('title', 'Laporan Penjualan')

@section('content')
    <h1>Laporan Penjualan</h1>

    <form action="{{ route('reports.index') }}" method="GET" class="toolbar no-print">
        <label for="dari" style="margin:0">Dari:</label>
        <input type="date" name="dari" id="dari" value="{{ $dari }}">
        <label for="sampai" style="margin:0">Sampai:</label>
        <input type="date" name="sampai" id="sampai" value="{{ $sampai }}">
        <button type="submit" class="btn btn-gray">Tampilkan</button>
        <button type="button" class="btn" onclick="window.print()">Cetak</button>
    </form>

    <div class="stats-grid">
        <div class="stat-card">
            <div class="value">{{ $transactions->count() }}</div>
            <div class="label">Jumlah Transaksi</div>
        </div>
        <div class="stat-card">
            <div class="value">Rp {{ number_format($omzet, 0, ',', '.') }}</div>
            <div class="label">Total Omzet</div>
        </div>
    </div>

    <h2>Penjualan per Produk</h2>
    <table>
        <thead>
            <tr>
                <th>Produk</th>
                <th class="right">Terjual</th>
                <th class="right">Omzet</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($perProduk as $row)
                <tr>
                    <td>{{ $row->product->nama }}</td>
                    <td class="right">{{ $row->total_qty }}</td>
                    <td class="right">Rp {{ number_format($row->total_omzet, 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="3">Tidak ada penjualan pada rentang ini.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <h2>Daftar Transaksi</h2>
    <table>
        <thead>
            <tr>
                <th>Kode</th>
                <th>Tanggal</th>
                <th>Kasir</th>
                <th class="right">Total</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($transactions as $transaction)
                <tr>
                    <td>{{ $transaction->kode_transaksi }}</td>
                    <td>{{ $transaction->created_at->format('d-m-Y H:i') }}</td>
                    <td>{{ $transaction->user->name }}</td>
                    <td class="right">Rp {{ number_format($transaction->total, 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4">Tidak ada transaksi pada rentang ini.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection
