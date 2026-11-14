@extends('layouts.app')

@section('title', 'Tambah Kategori')

@section('content')
    <h1>Tambah Kategori</h1>
    <p><a href="{{ route('categories.index') }}">&larr; Kembali</a></p>

    <form action="{{ route('categories.store') }}" method="POST" class="form-box">
        @csrf
        @include('categories._form')
        <p><button type="submit" class="btn">Simpan</button></p>
    </form>
@endsection
    