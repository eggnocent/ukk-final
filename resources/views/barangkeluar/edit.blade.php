@extends('layout.main')

@section('content')
    <div class="container">
        <h1>Edit Barang keluar</h1>
        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
        <form method="POST" action="{{ route('barangkeluar.update', $barangkeluar->id) }}">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="tgl_keluar">Tanggal keluar:</label>
                <input type="date" name="tgl_keluar" id="tgl_keluar" class="form-control" value="{{ $barangkeluar->tgl_keluar }}">
            </div>

            <div class="form-group">
                <label for="qty_keluar">Jumlah keluar:</label>
                <input type="number" name="qty_keluar" id="qty_keluar" class="form-control" value="{{ $barangkeluar->qty_keluar }}">
            </div>

            <div class="form-group">
                <label for="barang_id">Barang:</label>
                <select name="barang_id" id="barang_id" class="form-control">
                    @foreach($barangs as $barang)
                        <option value="{{ $barang->id }}" {{ $barang->id === $barangkeluar->barang_id ? 'selected' : '' }}>
                            {{ $barang->merk }} - {{ $barang->seri }}
                        </option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            <a href="{{ route('barangkeluar.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
@endsection