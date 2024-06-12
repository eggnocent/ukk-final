@extends('layout.main')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-2 text-gray-800">Hasil Pencarian</h1>

    <!-- Tabel Hasil Pencarian -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Hasil Pencarian</h6>
        </div>
        <div class="card-body">
            @if($results['kategori']->isEmpty() && $results['barang']->isEmpty())
                <p>Tidak ada hasil ditemukan.</p>
            @else
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Barang</th>
                                <th>Kategori</th>
                                <th>Spesifikasi</th>
                                <th>Stok</th>
                                <th>Aksi</th> <!-- Kolom aksi ditambahkan -->
                            </tr>
                        </thead>
                        <tbody>
                            @php $no = 1; @endphp
                            @foreach($results['kategori'] as $kategori)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>{{ $kategori->deskripsi }}</td>
                                    <td>{{ $kategori->kategori }}</td>
                                    <td>{{ $kategori->spesifikasi }}</td>
                                    <td>-</td>
                                    <td>
                                        <a href="{{ route('kategori.show', $kategori->id) }}" class="btn btn-info btn-sm">View</a>
                                        <a href="{{ route('kategori.edit', $kategori->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                        <form action="{{ route('kategori.destroy', $kategori->id) }}" method="POST" style="display:inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus item ini?')">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            @foreach($results['barang'] as $barang)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>{{ $barang->merk }} {{ $barang->seri }}</td>
                                    <td>{{ $barang->kategori->kategori }}</td>
                                    <td>{{ $barang->spesifikasi }}</td>
                                    <td>{{ $barang->stok }}</td>
                                    <td>
                                        <a href="{{ route('barang.show', $barang->id) }}" class="btn btn-info btn-sm">View</a>
                                        <a href="{{ route('barang.edit', $barang->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                        <form action="{{ route('barang.destroy', $barang->id) }}" method="POST" style="display:inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus item ini?')">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection