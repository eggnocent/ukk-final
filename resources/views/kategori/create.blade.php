@extends('layout.main')

@section('content')
    <div class="container">
        <h1>Add Kategori</h1>
        <form method="POST" action="{{ route('kategori.store') }}">
            @csrf

            <div class="form-group">
                <label for="deskripsi">Deskripsi:</label>
                <input type="text" name="deskripsi" id="deskripsi" class="form-control">
            </div>

            <div class="form-group">
                <label for="kategori">Kategori:</label>
                <select name="kategori" id="kategori" class="form-control">
                    <option value="M">Barang Modal</option>
                    <option value="A">Alat</option>
                    <option value="BHP">Bahan Habis Pakai</option>
                    <option value="BTHP">Bahan Tidak Habis Pakai</option>
                </select>
            </div>
            <a href="{{ route('kategori.index') }}" class="btn btn-secondary">Cancel</a>
            <button type="submit" class="btn btn-primary">Add</button>
        </form>
    </div>
@endsection