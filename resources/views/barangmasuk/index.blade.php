@extends('layout.main')

@section('content')
    <div class="container">
        <h2>Daftar Barang Masuk</h2>
        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
        <a href="{{ route('barangmasuk.create') }}" class="btn btn-success mb-3">Tambah Barang Masuk</a>

        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tanggal Masuk</th>
                    <th>Qty Masuk</th>
                    <th>Nama Barang</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($barangmasuks as $barangmasuk)
                    <tr>
                        <td>{{ $barangmasuk->id }}</td>
                        <td>{{ $barangmasuk->tgl_masuk }}</td>
                        <td>{{ $barangmasuk->qty_masuk }}</td>
                        <td>{{ $barangmasuk->barang->merk }} - {{ $barangmasuk->barang->seri }}</td>
                        <td>
                            <a href="{{ route('barangmasuk.show', $barangmasuk->id) }}" class="btn btn-info btn-sm">Detail</a>
                            <a href="{{ route('barangmasuk.edit', $barangmasuk->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('barangmasuk.destroy', $barangmasuk->id) }}" method="POST" class="d-inline">
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

        {{ $barangmasuks->links() }}
    </div>
@endsection