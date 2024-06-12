<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kategori;
use App\Models\Barang;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->input('query');

        $kategoriResults = Kategori::search($query);
        $barangResults = Barang::search($query);

        // Gabungkan hasil pencarian
        $results = [
            'kategori' => $kategoriResults,
            'barang' => $barangResults
        ];

        return view('search.results', ['results' => $results, 'query' => $query]);
    }
}