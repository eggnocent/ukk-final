@extends('layout.main')

@section('content')
    <div class="container">
        <h1>Edit Kategori</h1>
        <form method="POST" action="{{ route('kategori.update', $rsetKategori->id) }}">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="deskripsi">Deskripsi:</label>
                <input type="text" class="form-control" id="deskripsi" name="deskripsi" value="{{ $rsetKategori->deskripsi }}">
            </div>
            <div class="form-group">
                <label for="kategori">Kategori:</label>
                <select class="form-control" id="kategori" name="kategori">
                    @foreach ($aKategori as $key => $value)
                        <option value="{{ $key }}" {{ $key == $rsetKategori->kategori ? 'selected' : '' }}>{{ $value }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ route('kategori.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
@endsection