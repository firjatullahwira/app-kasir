@extends('layouts.app')

@section('title', 'Tambah Produk')

@section('content')
    <h1>Tambah Produk</h1>
    <p><a href="{{ route('products.index') }}">&larr; Kembali</a></p>

    <form action="{{ route('products.store') }}" method="POST" class="form-box">
        @csrf
        @include('products._form')
        <p><button type="submit" class="btn">Simpan</button></p>
    </form>
@endsection
