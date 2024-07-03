<?php

namespace App\Http\Controllers;

use App\Models\Komoditi;
use App\Models\Kategori;
use Illuminate\Http\Request;
use App\Exports\KomoditiExport;
use App\Imports\KomoditiImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;

class KomoditiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Check if the request has a 'view_all' parameter
        $viewAll = $request->has('view_all');
        $komoditis = $viewAll ? Komoditi::all() : Komoditi::paginate(5);
        return view('komoditi.index', compact('komoditis', 'viewAll'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kategoris = Kategori::all();
        return view('komoditi.create', compact('kategoris'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'kategori_id' => 'required',
            'jenis_komoditi' => 'required',
            'gambar_komoditi' => 'required|image',
        ]);

        $path = $request->file('gambar_komoditi')->store('public/gambar_komoditi');

        $kategori = Kategori::find($request->kategori_id);
        $komoditi = Komoditi::create([
            'kategori_id' => $request->kategori_id,
            'jenis_komoditi' => $request->jenis_komoditi,
            'gambar_komoditi' => basename($path),
        ]);

        $message = "Komoditi {$komoditi->jenis_komoditi} From the \"{$kategori->nama_kategori}\" Category Successfully Created.";

        return redirect()->route('komoditi.index')->with('success', $message);
    }

    public function import(Request $request)
    {
        $request->validate([
            'excel_file' => 'required|mimes:xlsx,xls',
        ]);

        try {
            $import = new KomoditiImport;
            Excel::import($import, $request->file('excel_file'));

            // Menghitung jumlah data yang berhasil diimport
            $rowCount = $import->getRowCount();
            $importedJenis = implode(', ', $import->getImportedJenis());

            $message = "$rowCount Data Komoditi $importedJenis Successfully Imported.";
            return redirect()->route('komoditi.index')->with('success', $message);
        } catch (\Exception $e) {
            return redirect()->route('komoditi.index')->with('error', 'Failed to Import Data Komoditi: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Komoditi $komoditi)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Komoditi $komoditi)
    {
        $kategoris = Kategori::all();
        return view('komoditi.edit', compact('komoditi', 'kategoris'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Komoditi $komoditi)
    {
        $request->validate([
            'kategori_id' => 'required',
            'jenis_komoditi' => 'required',
            'gambar_komoditi' => 'image',
        ]);

        $data = $request->only(['kategori_id', 'jenis_komoditi']);
        if ($request->hasFile('gambar_komoditi')) {
            // Hapus gambar lama jika ada
            if ($komoditi->gambar_komoditi) {
                Storage::delete('public/gambar_komoditi/' . $komoditi->gambar_komoditi);
            }
            $path = $request->file('gambar_komoditi')->store('public/gambar_komoditi');
            $data['gambar_komoditi'] = basename($path);
        }

        $komoditi->update($data);
        $kategori = Kategori::find($komoditi->kategori_id);

        $message = "Komoditi {$komoditi->jenis_komoditi} From the \"{$kategori->nama_kategori}\" Category Successfully Updated.";

        return redirect()->route('komoditi.index')->with('success', $message);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Komoditi $komoditi)
    {
        $jenisKomoditi = $komoditi->jenis_komoditi;
        $kategori = Kategori::find($komoditi->kategori_id)->nama_kategori;

        // Delete image if exists
        if ($komoditi->gambar_komoditi) {
            Storage::delete('public/gambar_komoditi/' . $komoditi->gambar_komoditi);
        }

        $komoditi->delete();
        $message = "Komoditi {$jenisKomoditi} From the \"{$kategori}\" Category Successfully Deleted.";

        return redirect()->route('komoditi.index')->with('success', $message);
    }

    public function export()
    {
        return Excel::download(new KomoditiExport, 'dataKomoditi.xlsx');
    }

    /**
     * Show the preview of data to be exported.
     */
    public function preview()
    { 
        $komoditis = Komoditi::all();
        return view('komoditi.preview', compact('komoditis'));
    }
}
