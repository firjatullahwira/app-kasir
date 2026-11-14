@extends('layouts.app')

@section('title', 'Kasir')

@section('content')
    <h1>Transaksi Baru</h1>
    <p>Isi jumlah pada produk yang dibeli. Total dan kembalian dihitung otomatis.</p>

    @if ($errors->any())
        <div class="alert-error">
            @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    <form action="{{ route('transactions.store') }}" method="POST">
        @csrf

        <table>
            <thead>
                <tr>
                    <th>Kode</th>
                    <th>Produk</th>
                    <th class="right">Harga</th>
                    <th class="right">Stok</th>
                    <th>Jumlah</th>
                    <th class="right">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($products as $product)
                    <tr>
                        <td>{{ $product->kode }}</td>
                        <td>{{ $product->nama }}</td>
                        <td class="right">Rp {{ number_format($product->harga, 0, ',', '.') }}</td>
                        <td class="right">{{ $product->stok }}</td>
                        <td>
                            <input type="number" class="qty" name="items[{{ $product->id }}]"
                                   min="0" max="{{ $product->stok }}"
                                   value="{{ old('items.'.$product->id, 0) }}"
                                   data-harga="{{ $product->harga }}">
                        </td>
                        <td class="right subtotal">Rp 0</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6">Belum ada produk dengan stok tersedia.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <p class="summary">Total: <strong id="total">Rp 0</strong></p>

        <div class="form-box">
            <label for="bayar">Uang Bayar (Rp)</label>
            <input type="number" name="bayar" id="bayar" min="0" value="{{ old('bayar') }}">
        </div>

        <p class="summary">Kembalian: <strong id="kembalian">Rp 0</strong></p>

        <p><button type="submit" class="btn">Simpan Transaksi</button></p>
    </form>

    <script>
        const fmt = (n) => 'Rp ' + n.toLocaleString('id-ID');
        const qtyInputs = document.querySelectorAll('.qty');
        const bayar = document.getElementById('bayar');

        function hitung() {
            let total = 0;

            qtyInputs.forEach((input) => {
                const qty = parseInt(input.value) || 0;
                const subtotal = qty * parseInt(input.dataset.harga);
                input.closest('tr').querySelector('.subtotal').textContent = fmt(subtotal);
                total += subtotal;
            });

            document.getElementById('total').textContent = fmt(total);

            const kembali = (parseInt(bayar.value) || 0) - total;
            document.getElementById('kembalian').textContent = kembali >= 0 ? fmt(kembali) : 'Uang kurang';
        }

        qtyInputs.forEach((input) => input.addEventListener('input', hitung));
        bayar.addEventListener('input', hitung);
        hitung();
    </script>
@endsection
