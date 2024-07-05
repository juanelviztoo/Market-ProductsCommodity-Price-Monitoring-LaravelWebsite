<?php

namespace App\Http\Controllers;

use App\Models\RiwayatHargaKomoditi;
use App\Models\Pasar;
use App\Models\Komoditi;
use App\Models\ProdukKomoditi;
use App\Exports\RiwayatHargaKomoditiExport;
use App\Imports\RiwayatHargaKomoditiImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;

class RiwayatHargaKomoditiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Check if the request has a 'view_all' parameter
        $viewAll = $request->has('view_all');
        $riwayats = $viewAll ? RiwayatHargaKomoditi::all() : RiwayatHargaKomoditi::paginate(5);
        return view('riwayat_harga_komoditi.index', compact('riwayats', 'viewAll'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pasars = Pasar::all();
        $komoditis = Komoditi::all();
        $produkKomoditis = ProdukKomoditi::all();
        return view('riwayat_harga_komoditi.create', compact('pasars', 'komoditis', 'produkKomoditis'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'pasar_id' => 'required',
            'komoditi_id' => 'required',
            'produk_komoditi_id' => 'nullable',
            'tanggal_update' => 'required|date',
            'harga' => 'required|numeric',
            'status' => 'required',
        ]);

        // // Log the request data
        // Log::info('Request data: ', $request->all());

        // // Log to check if the create method is reached
        // Log::info('Creating RiwayatHargaKomoditi');

        $riwayatHargaKomoditi = RiwayatHargaKomoditi::create($request->all());

        // // Log to check if the data is successfully created
        // Log::info('RiwayatHargaKomoditi created successfully');

        return redirect()->route('riwayat_harga_komoditi.index')->with('success', "Riwayat Harga Komoditi {$riwayatHargaKomoditi->produkKomoditi->nama_produk} at a Price of Rp" . number_format($riwayatHargaKomoditi->harga, 2, ',', '.') . " on {$riwayatHargaKomoditi->tanggal_update} Created Successfully.");
    }

    public function import(Request $request)
    {
        $request->validate([
            'excel_file' => 'required|mimes:xlsx,xls',
        ]);

        try {
            $import = new RiwayatHargaKomoditiImport;
            Excel::import($import, $request->file('excel_file'));

            $importedData = $import->getRowCount();
            $produkKomoditis = $import->getImportedProdukKomoditis();
            $statuses = $import->getStatuses();
            $formattedProdukKomoditis = implode(', ', $produkKomoditis);
            $formattedStatuses = implode(', ', $statuses);

            return redirect()->route('riwayat_harga_komoditi.index')->with('success', "{$importedData} Data Riwayat Harga Komoditi {$formattedProdukKomoditis} ({$formattedStatuses}) Imported Successfully.");
        } catch (\Exception $e) {
            return redirect()->route('riwayat_harga_komoditi.index')->with('error', 'Failed to Import Data Riwayat Harga Komoditi: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(RiwayatHargaKomoditi $riwayatHargaKomoditi)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(RiwayatHargaKomoditi $riwayatHargaKomoditi)
    {
        $pasars = Pasar::all();
        $komoditis = Komoditi::all();
        $produkKomoditis = ProdukKomoditi::all();
        return view('riwayat_harga_komoditi.edit', compact('riwayatHargaKomoditi', 'pasars', 'komoditis', 'produkKomoditis'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, RiwayatHargaKomoditi $riwayatHargaKomoditi)
    {
        $request->validate([
            'pasar_id' => 'required',
            'komoditi_id' => 'required',
            'produk_komoditi_id' => 'nullable',
            'tanggal_update' => 'required|date',
            'harga' => 'required|numeric',
            'status' => 'required',
        ]);

        $oldNamaProduk = $riwayatHargaKomoditi->produkKomoditi->nama_produk;
        $oldHarga = $riwayatHargaKomoditi->harga;
        $oldTanggalUpdate = $riwayatHargaKomoditi->tanggal_update;

        $riwayatHargaKomoditi->update($request->all());

        return redirect()->route('riwayat_harga_komoditi.index')->with('success', "Riwayat Harga Komoditi {$oldNamaProduk} at a Price of Rp" . number_format($oldHarga, 2, ',', '.') . " on {$oldTanggalUpdate} Updated Successfully.");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RiwayatHargaKomoditi $riwayatHargaKomoditi)
    {
        $namaProduk = $riwayatHargaKomoditi->produkKomoditi->nama_produk;
        $harga = $riwayatHargaKomoditi->harga;
        $tanggalUpdate = $riwayatHargaKomoditi->tanggal_update;

        $riwayatHargaKomoditi->delete();
        return redirect()->route('riwayat_harga_komoditi.index')->with('success', "Riwayat Harga Komoditi {$namaProduk} at a Price of Rp" . number_format($harga, 2, ',', '.') . " on {$tanggalUpdate} Deleted Successfully.");
    }

    public function export()
    {
        return Excel::download(new RiwayatHargaKomoditiExport, 'dataRiwayatHargaKomoditi.xlsx');
    }

    /**
     * Show the preview of data to be exported.
     */
    public function preview()
    {
        $riwayats = RiwayatHargaKomoditi::all();
        return view('riwayat_harga_komoditi.preview', compact('riwayats'));
    }
}
