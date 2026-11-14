@extends('layouts.app')

@section('title', 'Edit Produk')

@section('content')
    <h1>Edit Produk</h1>
    <p><a href="{{ route('products.index') }}">&larr; Kembali</a></p>

    <form action="{{ route('products.update', $product) }}" method="POST" class="form-box">
        @csrf
        @method('PUT')
        @include('products._form')
        <p><button type="submit" class="btn">Perbarui</button></p>
    </form>
@endsection
