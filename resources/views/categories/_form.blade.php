<label for="nama_kategori">Nama Kategori</label>
<input type="text" name="nama_kategori" id="nama_kategori" value="{{ old('nama_kategori', $category->nama_kategori ?? '') }}">
@error('nama_kategori')
    <div class="error">{{ $message }}</div>
@enderror

<label for="deskripsi">Deskripsi (opsional)</label>
<textarea name="deskripsi" id="deskripsi" rows="4">{{ old('deskripsi', $category->deskripsi ?? '') }}</textarea>
@error('deskripsi')
    <div class="error">{{ $message }}</div>
@enderror
