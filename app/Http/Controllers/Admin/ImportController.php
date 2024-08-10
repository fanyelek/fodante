<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ServiceImport;
use App\Imports\KotaImport;
use App\Imports\KecamatanImport;
use App\Imports\KelurahanImport;
use App\Imports\KunImport;
use App\Imports\KunjunganImport;
use App\Imports\Dokter;
use App\Models\Kota;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use App\Models\DataDokter;
use App\Models\DataService;
use Illuminate\Http\Request;

class ImportController extends Controller
{

    public function import_data_kota(Request $request)
    {

        // dd($request);
        // Import data Kota
        Excel::import(new KotaImport, $request->file('kota_file'));

        // Import data Kecamatan
        Excel::import(new KecamatanImport, $request->file('kecamatan_file'));

        // Import data Kelurahan
        Excel::import(new KelurahanImport, $request->file('kelurahan_file'));

        $data_kota = Kota::all();
        $data_kecamatan = Kecamatan::all();
        $data_kelurahan = Kelurahan::all();
        return redirect()->back()->with('success', 'Data imported successfully', compact('data_kota','data_kecamatan','data_kelurahan'));
    }

    public function import_data_kunjungan(Request $request)
    {
        Excel::import(new KunjunganImport, $request->file('detail_service_file'));

        $data_kota = Kota::all();
        $data_kecamatan = Kecamatan::all();
        $data_kelurahan = Kelurahan::all();
        return redirect()->back()->with('success', 'Data imported successfully', compact('data_kota','data_kecamatan','data_kelurahan'));
    }

    public function import_data_dentis(Request $request)
    {
        Excel::import(new Dokter, $request->file('file_data_dentis'));

        $data_dentis = DataDokter::all();
        return redirect()->back()->with('success', 'Data imported successfully', compact('data_dentis'));
    }

    public function import_data_service(Request $request)
    {
        Excel::import(new ServiceImport, $request->file('importService'));

        $service = DataService::all();
        return redirect()->back()->with('success', 'Data imported successfully', compact('service'));
    }
}
