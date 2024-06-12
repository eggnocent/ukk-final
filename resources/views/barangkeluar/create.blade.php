@extends('layout.main')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Tambah Barang Keluar</div>

                    <div class="card-body">
                    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
                        <form method="POST" action="{{ route('barangkeluar.store') }}">
                            @csrf

                            <div class="form-group">
                                <label for="tgl_keluar">Tanggal Keluar:</label>
                                <input type="date" name="tgl_keluar" id="tgl_keluar" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label for="qty_keluar">Jumlah Keluar:</label>
                                <input type="number" name="qty_keluar" id="qty_keluar" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label for="barang_id">Barang:</label>
                                <select name="barang_id" id="barang_id" class="form-control" required>
                                    @foreach ($barangs as $barang)
                                        <option value="{{ $barang->id }}">{{ $barang->merk }} - {{ $barang->seri }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <button type="submit" class="btn btn-primary">Tambah Barang keluar</button>

                            <a href="{{ route('barangkeluar.index') }}" class="btn btn-secondary">Kembali</a>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection