<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BarangMasuk;
use App\Models\Barang;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Validation\ValidatesRequests;
use App\Models\BarangKeluar;

class BarangMasukController extends Controller
{
    use ValidatesRequests;

    public function index()
    {
        $barangmasuks = BarangMasuk::with('barang')->paginate(10);
        return view('barangmasuk.index', compact('barangmasuks'));
    }

    public function create()
    {
        $barangs = Barang::all();
        return view('barangmasuk.create', compact('barangs'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'tgl_masuk' => 'required|date',
            'qty_masuk' => 'required|integer|min:1',
            'barang_id' => 'required|exists:barang,id',
        ]);

        // Cari barang masuk yang sudah ada dengan barang_id yang sama dan tanggal masuk yang sama
        $existingBarangMasuk = BarangMasuk::where('barang_id', $request->barang_id)
            ->where('tgl_masuk', $request->tgl_masuk)
            ->first();

        if ($existingBarangMasuk) {
            // Jika ada, tambahkan qty_masuk yang baru ke qty_masuk yang sudah ada
            $existingBarangMasuk->qty_masuk += $request->qty_masuk;
            $existingBarangMasuk->save();
        } else {
            // Cari barang masuk yang sudah ada dengan barang_id yang sama tetapi tanggal masuk yang berbeda
            $otherBarangMasuk = BarangMasuk::where('barang_id', $request->barang_id)
                ->where('tgl_masuk', '!=', $request->tgl_masuk)
                ->first();

            if ($otherBarangMasuk) {
                // Jika ada, buat entri baru dengan tanggal masuk yang baru
                $barangmasuk = BarangMasuk::create([
                    'tgl_masuk' => $request->tgl_masuk,
                    'qty_masuk' => $request->qty_masuk,
                    'barang_id' => $request->barang_id,
                ]);
            } else {
                // Jika tidak ada, tambahkan entri baru
                $barangmasuk = BarangMasuk::create($request->all());
            }
        }

        return redirect()->route('barangmasuk.index')->with(['success' => 'Data Barang Masuk Berhasil Disimpan!']);
    }

    public function show($id)
    {
        $barangmasuk = BarangMasuk::findOrFail($id);
        return view('barangmasuk.show', compact('barangmasuk'));
    }

    public function edit($id)
    {
        $barangmasuk = BarangMasuk::findOrFail($id);
        $barangs = Barang::all();
        return view('barangmasuk.edit', compact('barangmasuk', 'barangs'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'tgl_masuk' => 'required|date',
            'qty_masuk' => 'required|integer|min:1',
            'barang_id' => 'required|exists:barang,id',
        ]);

        $barangmasuk = BarangMasuk::findOrFail($id);
        $oldQty = $barangmasuk->qty_masuk;

        $barangmasuk->update($request->all());

        // Update stok barang terkait
        $barang = Barang::find($request->barang_id);
        $barang->stok += $request->qty_masuk - $oldQty;
        $barang->save();

        return redirect()->route('barangmasuk.index')->with(['success' => 'Data Barang Masuk Berhasil Diperbarui!']);
    }

    public function destroy($id)
    {
        $barangmasuk = BarangMasuk::findOrFail($id);
        $barangKeluarCount = BarangKeluar::where('barang_id', $barangmasuk->barang_id)
            ->where('tgl_keluar', '>=', $barangmasuk->tgl_masuk)
            ->count();

        // Jika ada catatan barangkeluar terkait, kembalikan pesan kesalahan
        if ($barangKeluarCount > 0) {
            return redirect()->route('barangmasuk.index')->withErrors(['error' => 'Data Barang Masuk tidak dapat dihapus karena ada Barang Keluar yang terkait.']);
        }

        // Mengurangi stok barang terkait
        $barang = Barang::find($barangmasuk->barang_id);
        $barang->stok -= $barangmasuk->qty_masuk;
        $barang->save();

        $barangmasuk->delete();

        return redirect()->route('barangmasuk.index')->with(['success' => 'Data Barang Masuk Berhasil Dihapus!']);
    }

    public function updateAPIBarangMasuk(Request $request, $barang_masuk_id)
    {
        $barangMasuk = BarangMasuk::find($barang_masuk_id);

        if (null == $barangMasuk) {
            return response()->json(['status' => "BarangMasuk tidak ditemukan"]);
        }

        $barangMasuk->tgl_masuk = $request->tanggalmasuk;
        $barangMasuk->qty_masuk = $request->jumlahmasuk;
        $barangMasuk->barang_id = $request->barang;
        $barangMasuk->save();

        return response()->json(["status" => "BarangMasuk berhasil diubah"]);
    }

    public function showAPIBarangMasuk(Request $request)
    {
        $barangMasuk = BarangMasuk::all();
        return response()->json($barangMasuk);
    }

    public function createAPIBarangMasuk(Request $request)
    {
        $this->validate($request, [
            'tgl_masuk' => 'required|date',
            'qty_masuk' => 'required|integer|min:1',
            'barang_id' => 'required|exists:barang,id',
        ]);

        // Simpan data BarangMasuk
        $barangMasuk = BarangMasuk::create([
            'tgl_masuk' => $request->tanggalmasuk,
            'qty_masuk' => $request->jumlahmasuk,
            'barang_id' => $request->barang,
        ]);

        return response()->json(["status" => "data berhasil dibuat"]);
    }

    public function deleteAPIBarangMasuk($barang_masuk_id)
    {
        $del_barangMasuk = BarangMasuk::findOrFail($barang_masuk_id);
        $del_barangMasuk->delete();

        return response()->json(["status" => "data berhasil dihapus"]);
    }
}