@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <h1>Dashboard</h1>

    <div class="stats-grid">
        <div class="stat-card">
            <div class="value">{{ $stats['total_produk'] }}</div>
            <div class="label">Total Produk</div>
        </div>
        <div class="stat-card">
            <div class="value">{{ $stats['stok_menipis'] }}</div>
            <div class="label">Stok Menipis (≤ 5)</div>
        </div>
        <div class="stat-card">
            <div class="value">{{ $stats['transaksi_hari_ini'] }}</div>
            <div class="label">Transaksi Hari Ini</div>
        </div>
        <div class="stat-card">
            <div class="value">Rp {{ number_format($stats['omzet_hari_ini'], 0, ',', '.') }}</div>
            <div class="label">Omzet Hari Ini</div>
        </div>
    </div>

    <p style="margin-top: 24px;"><a href="{{ route('transactions.create') }}" class="btn">+ Transaksi Baru</a></p>

    <h2>Stok Menipis</h2>
    <table>
        <thead>
            <tr>
                <th>Kode</th>
                <th>Produk</th>
                <th class="right">Stok</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($stokMenipis as $product)
                <tr>
                    <td>{{ $product->kode }}</td>
                    <td>{{ $product->nama }}</td>
                    <td class="right">{{ $product->stok }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="3">Semua stok aman.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <h2>Transaksi Terbaru</h2>
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
            @forelse ($terbaru as $transaction)
                <tr>
                    <td><a href="{{ route('transactions.show', $transaction) }}">{{ $transaction->kode_transaksi }}</a></td>
                    <td>{{ $transaction->created_at->format('d-m-Y H:i') }}</td>
                    <td>{{ $transaction->user->name }}</td>
                    <td class="right">Rp {{ number_format($transaction->total, 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4">Belum ada transaksi.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection
