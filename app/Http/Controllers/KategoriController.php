<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;
use App\Imports\KategoriImport;
use App\Exports\KategoriExport;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Illuminate\Support\Facades\Response;

class KategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kategoris = Kategori::all();
        return view('kategori.index', compact('kategoris'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('kategori.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate(['nama_kategori' => 'required']);
        $kategori = Kategori::create($request->all());;
        return redirect()->route('kategori.index')->with('success', "Kategori {$kategori->nama_kategori} Created Successfully.");
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv',
        ]);

        $file = $request->file('file');

        try {
            $import = new KategoriImport;
            Excel::import($import, $file);

            $importedCount = $import->importedCount;
            $importedNames = implode(', ', $import->importedNames);

            return redirect()->route('kategori.index')->with('success', "$importedCount Data Kategori $importedNames Imported Successfully.");
        } catch (\Exception $e) {
            return redirect()->route('kategori.index')->with('error', 'Terjadi Kesalahan saat Mengimport Data.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Kategori $kategori)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Kategori $kategori)
    {
        return view('kategori.edit', compact('kategori'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Kategori $kategori)
    {
        $request->validate(['nama_kategori' => 'required']);
        $oldName = $kategori->nama_kategori;
        $kategori->update($request->all());
        $newName = $request->nama_kategori;
        return redirect()->route('kategori.index')->with('success', "Kategori $oldName Updated Successfully to $newName.");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Kategori $kategori)
    {
        $kategoriName = $kategori->nama_kategori;
        $kategori->delete();
        return redirect()->route('kategori.index')->with('success', "Kategori $kategoriName Deleted Successfully.");
    }

    public function export() 
    {
        return Excel::download(new KategoriExport, 'dataKategori.xlsx');
    }

    /**
     * Show the preview of data to be exported.
     */
    public function preview()
    {
        $kategoris = Kategori::all();
        return view('kategori.preview', compact('kategoris'));
    }
}