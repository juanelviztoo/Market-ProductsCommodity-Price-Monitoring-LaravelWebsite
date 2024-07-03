<?php

namespace App\Http\Controllers;

use App\Models\ProdukKomoditi;
use App\Models\Komoditi;
use Illuminate\Http\Request;
use App\Exports\ProdukKomoditiExport;
use App\Imports\ProdukKomoditiImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;

class ProdukKomoditiController extends Controller
{
    public function index(Request $request)
    {
        // Check if the request has a 'view_all' parameter
        $viewAll = $request->has('view_all');
        $produks = $viewAll ? ProdukKomoditi::all() : ProdukKomoditi::paginate(5);
        return view('produk_komoditi.index', compact('produks', 'viewAll'));
    }

    public function create()
    {
        $komoditis = Komoditi::all();
        return view('produk_komoditi.create', compact('komoditis'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'komoditi_id' => 'required',
            'nama_produk' => 'required',
            'gambar_produk' => 'nullable|image',
            'satuan' => 'required|string',
        ]);

        if ($request->hasFile('gambar_produk')) {
            $path = $request->file('gambar_produk')->store('public/gambar_produk');
            $gambar_produk = basename($path);
        } else {
            $gambar_produk = null;
        }

        $komoditi = Komoditi::find($request->komoditi_id);
        $produk = ProdukKomoditi::create([
            'komoditi_id' => $request->komoditi_id,
            'nama_produk' => $request->nama_produk,
            'gambar_produk' => $gambar_produk,
            'satuan' => $request->satuan,
        ]);

        $message = "Produk Komoditi {$produk->nama_produk} by Unit ({$produk->satuan}) of the Komoditi type \"{$komoditi->jenis_komoditi}\" Successfully Created.";

        return redirect()->route('produk_komoditi.index')->with('success', $message);
    }

    public function import(Request $request)
    {
        $request->validate([
            'excel_file' => 'required|mimes:xlsx,xls',
        ]);

        try {
            $import = new ProdukKomoditiImport;
            Excel::import($import, $request->file('excel_file'));

            // Menghitung jumlah data yang berhasil diimport
            $rowCount = $import->getRowCount();
            $importedNames = implode(', ', $import->getImportedNames());

            $message = "$rowCount Data Produk Komoditi $importedNames Successfully Imported.";
            return redirect()->route('produk_komoditi.index')->with('success', $message);
        } catch (\Exception $e) {
            return redirect()->route('produk_komoditi.index')->with('error', 'Failed to Import Data Produk Komoditi: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(ProdukKomoditi $produkKomoditi)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProdukKomoditi $produkKomoditi)
    {
        $komoditis = Komoditi::all();
        return view('produk_komoditi.edit', compact('produkKomoditi', 'komoditis'));
    }

    public function update(Request $request, ProdukKomoditi $produkKomoditi)
    {
        $request->validate([
            'komoditi_id' => 'required',
            'nama_produk' => 'required',
            'gambar_produk' => 'nullable|image',
            'satuan' => 'required|string',
        ]);

        $data = $request->only(['komoditi_id', 'nama_produk', 'satuan']);
        if ($request->hasFile('gambar_produk')) {
            // Hapus gambar lama jika ada
            if ($produkKomoditi->gambar_produk) {
                Storage::delete('public/gambar_produk/' . $produkKomoditi->gambar_produk);
            }
            $path = $request->file('gambar_produk')->store('public/gambar_produk');
            $data['gambar_produk'] = basename($path);
        }

        $produkKomoditi->update($data);
        $komoditi = Komoditi::find($produkKomoditi->komoditi_id);

        $message = "Produk Komoditi {$produkKomoditi->nama_produk} by Unit ({$produkKomoditi->satuan}) of the Komoditi type \"{$komoditi->jenis_komoditi}\" Successfully Updated.";

        return redirect()->route('produk_komoditi.index')->with('success', $message);
    }

    public function destroy(ProdukKomoditi $produkKomoditi)
    {
        $namaProduk = $produkKomoditi->nama_produk;
        $satuan = $produkKomoditi->satuan;
        $jenisKomoditi = Komoditi::find($produkKomoditi->komoditi_id)->jenis_komoditi;

        // Delete image if exists
        if ($produkKomoditi->gambar_produk) {
            Storage::delete('public/gambar_produk/' . $produkKomoditi->gambar_produk);
        }

        $produkKomoditi->delete();
        $message = "Produk Komoditi {$namaProduk} by Unit ({$satuan}) of the Komoditi type \"{$jenisKomoditi}\" Successfully Deleted.";

        return redirect()->route('produk_komoditi.index')->with('success', $message);
    }

    public function export()
    {
        return Excel::download(new ProdukKomoditiExport, 'dataProdukKomoditi.xlsx');
    }

    public function preview()
    {
        $produks = ProdukKomoditi::all();
        return view('produk_komoditi.preview', compact('produks'));
    }
}
