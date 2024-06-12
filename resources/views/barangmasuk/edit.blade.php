@extends('layout.main')

@section('content')
    <div class="container">
        <h1>Edit Barang Masuk</h1>
        
        <form method="POST" action="{{ route('barangmasuk.update', $barangmasuk->id) }}">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="tgl_masuk">Tanggal Masuk:</label>
                <input type="date" name="tgl_masuk" id="tgl_masuk" class="form-control" value="{{ $barangmasuk->tgl_masuk }}">
            </div>

            <div class="form-group">
                <label for="qty_masuk">Jumlah Masuk:</label>
                <input type="number" name="qty_masuk" id="qty_masuk" class="form-control" value="{{ $barangmasuk->qty_masuk }}">
            </div>

            <div class="form-group">
                <label for="barang_id">Barang:</label>
                <select name="barang_id" id="barang_id" class="form-control">
                    @foreach($barangs as $barang)
                        <option value="{{ $barang->id }}" {{ $barang->id === $barangmasuk->barang_id ? 'selected' : '' }}>
                            {{ $barang->merk }} - {{ $barang->seri }}
                        </option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            <a href="{{ route('barangmasuk.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
@endsection