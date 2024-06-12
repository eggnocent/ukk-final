@extends('layout.main')

@section('content')
    <div class="container">
        <h2>Daftar Barang Keluar</h2>

        <a href="{{ route('barangkeluar.create') }}" class="btn btn-success mb-3">Tambah Barang Keluar</a>

        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tanggal Keluar</th>
                    <th>Qty Keluar</th>
                    <th>Nama Barang</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($barangkeluars as $barangkeluar)
                    <tr>
                        <td>{{ $barangkeluar->id }}</td>
                        <td>{{ $barangkeluar->tgl_keluar }}</td>
                        <td>{{ $barangkeluar->qty_keluar }}</td>
                        <td>{{ $barangkeluar->barang->merk }} - {{ $barangkeluar->barang->seri }}</td>
                        <td>
                            <a href="{{ route('barangkeluar.show', $barangkeluar->id) }}" class="btn btn-info btn-sm">Detail</a>
                            <a href="{{ route('barangkeluar.edit', $barangkeluar->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('barangkeluar.destroy', $barangkeluar->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus data?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5">Tidak ada data barang masuk.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{ $barangkeluars->links() }}
    </div>
@endsection