@extends('layout.main')

@section('content')
    <div class="container">
        <h1>Detail Barang Masuk</h1>
        
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Tanggal Masuk: {{ $barangmasuk->tgl_masuk }}</h5>
                <p class="card-text">Jumlah Masuk: {{ $barangmasuk->qty_masuk }}</p>
                
                <h5 class="mt-4">Detail Barang</h5>
                <ul>
                    <li>Merk: {{ $barangmasuk->barang->merk }}</li>
                    <li>Seri: {{ $barangmasuk->barang->seri }}</li>
                    <li>Spesifikasi: {{ $barangmasuk->barang->spesifikasi }}</li>
                    <li>Stok: {{ $barangmasuk->barang->stok }}</li>
                    <li>Kategori: {{ $barangmasuk->barang->kategori->deskripsi }}</li>
                </ul>
                
                <a href="{{ route('barangmasuk.index') }}" class="btn btn-primary">Kembali</a>
            </div>
        </div>
    </div>
@endsection