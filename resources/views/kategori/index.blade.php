@extends('layout.main')

@section('content')
    <div class="container">
        <h2>Daftar Kategori</h2>

        <a href="{{ route('kategori.create') }}" class="btn btn-primary mb-3">Create Kategori</a>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @elseif(session('Gagal'))
            <div class="alert alert-danger">
                {{ session('Gagal') }}
            </div>
        @endif
    
        <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Deskripsi</th>
                    <th>Kategori</th>
                    <!-- <th>Keterangan Kategori</th> -->
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($rsetKategori as $kategori)
                    <tr>
                        <td>{{ $kategori->id }}</td>
                        <td>{{ $kategori->deskripsi }}</td>
                        <td>{{ $kategori->kategori }}</td>
                        <!-- <td>{{ $kategori->ketkategori }}</td> -->
                        <td>
                            <a href="{{ route('kategori.show', $kategori->id) }}" class="btn btn-info"><i class="bi bi-eye"></i> Show</a>
                            <a href="{{ route('kategori.edit', $kategori->id) }}" class="btn btn-primary"><i class="bi bi-pencil"></i> Edit</a>
                            <form action="{{ route('kategori.destroy', $kategori->id) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this item?')"><i class="bi bi-trash"></i> Delete</button>  
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    </div>
@endsection