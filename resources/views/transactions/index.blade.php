@extends('layouts.app')

@section('title', 'Riwayat Transaksi')

@section('content')
    <h1>Riwayat Transaksi</h1>

    <form action="{{ route('transactions.index') }}" method="GET" class="toolbar">
        <label for="tanggal" style="margin:0">Tanggal:</label>
        <input type="date" name="tanggal" id="tanggal" value="{{ request('tanggal') }}">
        <button type="submit" class="btn btn-gray">Filter</button>
        <a href="{{ route('transactions.index') }}">Reset</a>
    </form>

    <table>
        <thead>
            <tr>
                <th>Kode</th>
                <th>Tanggal</th>
                <th>Kasir</th>
                <th class="right">Total</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($transactions as $transaction)
                <tr>
                    <td>{{ $transaction->kode_transaksi }}</td>
                    <td>{{ $transaction->created_at->format('d-m-Y H:i') }}</td>
                    <td>{{ $transaction->user->name }}</td>
                    <td class="right">Rp {{ number_format($transaction->total, 0, ',', '.') }}</td>
                    <td><a href="{{ route('transactions.show', $transaction) }}">Detail</a></td>
                </tr>
            @empty
                <tr>
                    <td colspan="5">Belum ada transaksi.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{ $transactions->links() }}
@endsection
