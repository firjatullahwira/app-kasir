@extends('layouts.app')

@section('title', 'Produk')

@section('content')
    <h1>Produk</h1>

    <div class="toolbar">
        <a href="{{ route('products.create') }}" class="btn">+ Tambah Produk</a>

        <form action="{{ route('products.index') }}" method="GET" class="toolbar">
            <input type="search" name="search" placeholder="Cari kode / nama..." value="{{ request('search') }}">
            <button type="submit" class="btn btn-gray">Cari</button>
        </form>
    </div>

    <table>
        <thead>
            <tr>
                <th>Kode</th>
                <th>Nama</th>
                <th>Kategori</th>
                <th class="right">Harga</th>
                <th class="right">Stok</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($products as $product)
                <tr>
                    <td>{{ $product->kode }}</td>
                    <td>{{ $product->nama }}</td>
                    <td>{{ $product->category->nama_kategori }}</td>
                    <td class="right">Rp {{ number_format($product->harga, 0, ',', '.') }}</td>
                    <td class="right">{{ $product->stok }}</td>
                    <td>
                        <a href="{{ route('products.edit', $product) }}">Edit</a>
                        |
                        <form class="inline" action="{{ route('products.destroy', $product) }}" method="POST"
                              onsubmit="return confirm('Hapus produk ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6">Belum ada produk.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{ $products->links() }}
@endsection
