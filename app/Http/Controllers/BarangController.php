<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\Kategori;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Validation\ValidatesRequests;

class BarangController extends Controller
{
    use ValidatesRequests;
    public function index(Request $request)
    {
        $rsetBarang = Barang::with('kategori')->latest()->paginate(10);

        return view('barang.index', compact('rsetBarang'))
            ->with('i', (request()->input('page', 1) - 1) * 10);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $akategori = Kategori::all();
        return view('barang.create',compact('akategori'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //return $request;
        //validate form
        $this->validate($request, [
            'merk'          => 'required',
            'seri'          => 'required',
            'spesifikasi'   => 'required',
            'kategori_id'   => 'required|not_in:blank',
            'foto'          => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'

        ]);

        //upload image
        $foto = $request->file('foto');
        $foto->storeAs('public/foto_barang', $foto->hashName());

        //create post
        Barang::create([
            'merk'             => $request->merk,
            'seri'             => $request->seri,
            'spesifikasi'      => $request->spesifikasi,
            'kategori_id'      => $request->kategori_id,
            'foto'             => $foto->hashName()
        ]);

        //redirect to index
        return redirect()->route('barang.index')->with(['success' => 'Data Berhasil Disimpan!']);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $rsetBarang = Barang::find($id);

        //return $rsetBarang;

        //return view
        return view('barang.show', compact('rsetBarang'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
    $akategori = Kategori::all();
    $rsetBarang = Barang::find($id);
    $selectedKategori = Kategori::find($rsetBarang->kategori_id);

    return view('barang.edit', compact('rsetBarang', 'akategori', 'selectedKategori'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->validate($request, [
            'merk'        => 'required',
            'seri'        => 'required',
            'spesifikasi' => 'required',
            // 'stok'        => 'required',
            'kategori_id' => 'required|not_in:blank',
            'foto'        => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        $rsetBarang = Barang::find($id);

        //check if image is uploaded
        if ($request->hasFile('foto')) {

            //upload new image
            $foto = $request->file('foto');
            $foto->storeAs('public/foto_barang', $foto->hashName());

            //delete old image
            Storage::delete('public/foto_barang/'.$rsetBarang->foto);

            //update post with new image
            $rsetBarang->update([
                'merk'          => $request->merk,
                'seri'          => $request->seri,
                'spesifikasi'   => $request->spesifikasi,
                // 'stok'          => $request->stok,
                'kategori_id'   => $request->kategori_id,
                'foto'          => $foto->hashName()
            ]);

        } else {

            //update post without image
            $rsetBarang->update([
                'merk'          => $request->merk,
                'seri'          => $request->seri,
                'spesifikasi'   => $request->spesifikasi,
                // 'stok'          => $request->stok,
                'kategori_id'   => $request->kategori_id,
            ]);
        }

        // Redirect to the index page with a success message
        return redirect()->route('barang.index')->with(['success' => 'Data Berhasil Diubah!']);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if (DB::table('barangmasuk')->where('barang_id', $id)->exists()) {
            return redirect()->route('barang.index')->with(['Gagal' => 'Data Gagal Dihapus!']);
        }
        elseif (DB::table('barangkeluar')->where('barang_id', $id)->exists()) {
            return redirect()->route('barang.index')->with(['Gagal' => 'Data Gagal Dihapus!']);
        }
        else {
            $rsetBarang = Barang::find($id);
            $rsetBarang->delete();
            return redirect()->route('barang.index')->with(['success' => 'Data Berhasil Dihapus!']);
        }
    }
    public function updateAPIBarang(Request $request, $barang_id)
    {
        $barang = Barang::find($barang_id);

        if (null == $barang) {
            return response()->json(['status' => "Barang tidak ditemukan"], 404);
        }

        $barang->merk = $request->merk;
        $barang->seri = $request->seri;
        $barang->spesifikasi = $request->spesifikasi;
        $barang->stok = $request->stok;
        $barang->kategori_id = $request->kategori;
        $barang->foto = $request->foto;
        $barang->save();

        return response()->json(["status" => "Barang berhasil diubah"], 200);
    }

    // Method to get all barang via API
    public function showAPIBarang(Request $request)
    {
        $barang = Barang::all();
        return response()->json($barang, 200);
    }

    // Method to create a new barang via API
    public function createAPIBarang(Request $request)
    {
        $this->validate($request, [
            'merk'          => 'required',
            'seri'          => 'required',
            'spesifikasi'   => 'required',
            'kategori_id'   => 'required|not_in:blank',
            'foto'          => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'

        ]);

        //upload image
        $foto = $request->file('foto');
        $foto->storeAs('public/foto_barang', $foto->hashName());

        //create post
        Barang::create([
            'merk'             => $request->merk,
            'seri'             => $request->seri,
            'spesifikasi'      => $request->spesifikasi,
            'kategori_id'      => $request->kategori_id,
            'foto'             => $foto->hashName()
        ]);


        return response()->json(["status" => "Data berhasil dibuat"], 201);
    }

    // Method to delete a barang via API
    public function deleteAPIBarang($barang_id)
    {
        $barang = Barang::findOrFail($barang_id);
        $barang->delete();

        return response()->json(["status" => "Data berhasil dihapus"], 200);
    }

}