@extends('layouts.app')

@section('title', 'Edit Kategori')

@section('content')
    <h1>Edit Kategori</h1>
    <p><a href="{{ route('categories.index') }}">&larr; Kembali</a></p>

    <form action="{{ route('categories.update', $category) }}" method="POST" class="form-box">
        @csrf
        @method('PUT')
        @include('categories._form')
        <p><button type="submit" class="btn">Perbarui</button></p>
    </form>
@endsection
