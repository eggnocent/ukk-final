@extends('layout.main')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Tambah Barang Masuk</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('barangmasuk.store') }}">
                            @csrf

                            <div class="form-group">
                                <label for="tgl_masuk">Tanggal Masuk:</label>
                                <input type="date" name="tgl_masuk" id="tgl_masuk" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label for="qty_masuk">Jumlah Masuk:</label>
                                <input type="number" name="qty_masuk" id="qty_masuk" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label for="barang_id">Barang:</label>
                                <select name="barang_id" id="barang_id" class="form-control" required>
                                    @foreach ($barangs as $barang)
                                        <option value="{{ $barang->id }}">{{ $barang->merk }} - {{ $barang->seri }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <button type="submit" class="btn btn-primary">Tambah Barang Masuk</button>

                            <a href="{{ route('barangmasuk.index') }}" class="btn btn-secondary">Kembali</a>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection