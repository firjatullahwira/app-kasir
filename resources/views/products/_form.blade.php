<label for="kode">Kode Produk</label>
<input type="text" name="kode" id="kode" value="{{ old('kode', $product->kode ?? '') }}">
@error('kode')
    <div class="error">{{ $message }}</div>
@enderror

<label for="nama">Nama Produk</label>
<input type="text" name="nama" id="nama" value="{{ old('nama', $product->nama ?? '') }}">
@error('nama')
    <div class="error">{{ $message }}</div>
@enderror

<label for="harga">Harga (Rp)</label>
<input type="number" name="harga" id="harga" min="0" value="{{ old('harga', $product->harga ?? '') }}">
@error('harga')
    <div class="error">{{ $message }}</div>
@enderror

<label for="stok">Stok</label>
<input type="number" name="stok" id="stok" min="0" value="{{ old('stok', $product->stok ?? 0) }}">
@error('stok')
    <div class="error">{{ $message }}</div>
@enderror

<label for="category_id">Kategori</label>
<select name="category_id" id="category_id">
    <option value="">-- Pilih Kategori --</option>
    @foreach ($categories as $category)
        <option value="{{ $category->id }}" @selected(old('category_id', $product->category_id ?? '') == $category->id)>
            {{ $category->nama_kategori }}
        </option>
    @endforeach
</select>
@error('category_id')
    <div class="error">{{ $message }}</div>
@enderror
