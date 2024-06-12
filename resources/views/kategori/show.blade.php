@extends('layout.main')

@section('content')
    <div class="container">
        <h2>Detail Kategori</h2>

        <table class="table">
            <tr>
                <th>ID</th>
                <td>{{ $rsetKategori->id }}</td>
            </tr>
            <tr>
                <th>Deskripsi</th>
                <td>{{ $rsetKategori->deskripsi }}</td>
            </tr>
            <tr>
                <th>Kategori</th>
                <td>{{ $rsetKategori->kategori }}</td>
            </tr>
            <a href="{{ route('kategori.index') }}" class="btn btn-primary">Back to Kategori</a>
            <a> </a>
            <a href="{{ route('barang.index') }}" class="btn btn-secondary">Back to Barang</a>
        </table>
    </div>
@endsection