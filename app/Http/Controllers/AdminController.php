<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kota;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use App\Models\Pasien;
use App\Models\DataDokter;
use App\Models\DataService;
use App\Models\DetailServicePasien;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\Dokter;
use App\Exports\DetailServiceExport;

class AdminController extends Controller
{
    
    public function view_customer()
    {
        $pasien = Pasien::withCount('detail_service_pasiens')->orderBy('created_at', 'desc')->get();
        return view('admin.page.dashboard',compact('pasien'));
        
    }

    public function view_dokter()
    {
        
        $dentist = DataDokter::all();
        // dd($dentist);
        return view('admin.page.data-dokter', compact('dentist'));
        
    }


    public function view_service()
    {
        
        $service = DataService::all();
        // dd($dentist);
        return view('admin.page.data-service', compact('service'));
        
    }

    
    public function view_data_kota()
    {
        $data_kota = Kota::all();
        $data_kecamatan = Kecamatan::all();
        $data_kelurahan = Kelurahan::all();
        return view('admin.page.data-kota',compact('data_kota','data_kecamatan','data_kelurahan'));
    }
    



    public function view_analisis_umur(Request $request)
    {
     
        // Mengambil data pasien dari database
        $pasiens = Pasien::all();

        // Mengelompokkan umur ke dalam range yang ditentukan
        $ageRanges = [
            '1-10' => 0,
            '11-17' => 0,
            '18-25' => 0,
            '26-35' => 0,
            '36+' => 0,
        ];

        foreach ($pasiens as $pasien) {
            if ($pasien->age <= 10) {
                $ageRanges['1-10']++;
            } elseif ($pasien->age <= 17) {
                $ageRanges['11-17']++;
            } elseif ($pasien->age <= 25) {
                $ageRanges['18-25']++;
            } elseif ($pasien->age <= 35) {
                $ageRanges['26-35']++;
            } else {
                $ageRanges['36+']++;
            }
        }

        return view('admin.page.analisis.umur', compact('ageRanges','pasien'));
        
    }


    
    public function view_analisis_dokter(Request $request)
    {
        
        // Ambil bulan saat ini sebagai default
        $bulan = now()->format('Y-m');

        return view('admin.page.analisis.dokter', [
            'bulan' => $bulan,
        ]);
        
    }



    public function getData_analisis_dentist(Request $request)
    {
        $bulan = $request->input('bulan', now()->format('Y-m'));

        // Ambil data layanan berdasarkan bulan
        $services = DetailServicePasien::with('dentist')
            ->whereMonth('tanggal', '=', date('m', strtotime($bulan)))
            ->whereYear('tanggal', '=', date('Y', strtotime($bulan)))
            ->get();

        // Hitung jumlah layanan per dokter
        $dataPerDokter = $services->groupBy('dentist_id')->map(function ($group) {
            return [
                'nama_dokter' => $group->first()->dentist->nama_dokter,
                'jumlah_layanan' => $group->count(),
            ];
        })->values();

        return response()->json($dataPerDokter);
    }




    
    public function view_analisis_service()
    {
        
        // Ambil bulan saat ini sebagai default
        $bulan = now()->format('Y-m');

        return view('admin.page.analisis.service', [
            'bulan' => $bulan,
        ]);
        
    }


    
    public function getData_analisis_service(Request $request)
    {
        
        $bulan = $request->input('bulan', now()->format('Y-m'));

        // Ambil data layanan berdasarkan bulan dengan eager loading untuk relasi layanan
        $services = DetailServicePasien::whereMonth('tanggal', '=', date('m', strtotime($bulan)))
            ->whereYear('tanggal', '=', date('Y', strtotime($bulan)))
            ->get();

        // Hitung jumlah layanan per nama service
        $dataPerService = $services->groupBy('service')->map(function ($group) {
            return [
                'service' => $group->first()->service,
                'jumlah_service' => $group->count(),
            ];
        })->values();

        return response()->json($dataPerService);
        
    }



    
    public function view_analisis_alamat()
    {
        
        return view('admin.page.analisis.alamat');
        
    }
    
    public function view_analisis_kunjungan()
    {
        
        return view('admin.page.analisis.kunjungan');
        
    }

    public function getPatientDetails($id)
    {
        $patient = Pasien::find($id);
        $services = DetailServicePasien::where('pasien_id', $id)->with(['dentist','pasien','service'])->get();
        
        return response()->json([
            'pasien' => $patient,
            'services' => $services
        ]);
    }

    public function get_item_service($id)
    {
        $services = DetailServicePasien::where('id', $id)->with(['dentist','pasien','service'])->get();
        
        return response()->json([
            'services' => $services
        ]);
    }

    


    public function get_item_dokter()
    {
        $dokters = DataDokter::all();
        
        return response()->json($dokters);
    }
    



    public function hapus_data_pasien($id)
    {
        // Temukan pasien berdasarkan ID dan hapus
        $patient = Pasien::findOrFail($id);
        $patient->delete();
        
        // Redirect atau response success
        return response()->json(['success' => true]);
    }
    
    public function hapus_data_item_service_pasien($id)
    {
        // Temukan pasien berdasarkan ID dan hapus
        $item = DetailServicePasien::findOrFail($id);
        $item->delete();
        
        // Redirect atau response success
        return response()->json(['success' => true]);
    }
    
    public function update_item_service(Request $request, $id)
    {

        // Validasi data yang diterima
        $validatedData = $request->validate([
            'tanggal' => 'required|date',
            // 'service' => 'required|string|max:255',
            'tarif' => 'required|numeric',
            'diskon_klinik' => 'required|numeric',
            'harga_bayar' => 'required|numeric',
        ]);

        // Cari data service berdasarkan ID
        $service = DetailServicePasien::find($id);

        // Pastikan service ada
        if (!$service) {
            return response()->json(['error' => 'Service not found'], 404);
        }

        // Update data service
        $service->tanggal = $validatedData['tanggal'];
        // $service->service = $validatedData['service'];
        $service->tarif = $validatedData['tarif'];
        $service->diskon_klinik = $validatedData['diskon_klinik'];
        $service->harga_bayar = $validatedData['harga_bayar'];
        // $service->dentist = $validatedData['dentist'];
        $service->save();

        // Kirim respon sukses
        return response()->json(['success' => 'Data service berhasil diperbarui']);
    

    }



    // untuk alamat
    
    public function search(Request $request)
    {
        $query = $request->input('query');
        $lokasi = Kelurahan::with(['kecamatan.kota'])
            ->where('nama_kelurahan', 'like', "%$query%")
            ->orWhereHas('kecamatan', function($q) use ($query) {
                $q->where('nama_kecamatan', 'like', "%$query%")
                ->orWhereHas('kota', function($q2) use ($query) {
                    $q2->where('nama_kota', 'like', "%$query%");
                });
            })
            ->get();
        return response()->json($lokasi);
    }






    public function search_dentist(Request $request)
    {
        $query = $request->get('query');

        // Mengambil data dokter dari model DataDokter berdasarkan query
        $doctors = DataDokter::where('nama_dokter', 'LIKE', "%{$query}%")->get();

        return response()->json($doctors);
    }

    public function searchService(Request $request)
    {
        $query = $request->query('query');
        $services = DataService::where('service', 'LIKE', '%' . $query . '%')->get();

        return response()->json($services);
    }



    
    
    
    public function getDentist($id)
    {
        $dentist = DataDokter::findOrFail($id);
        return response()->json($dentist);
    }
    

    public function store_dentist(Request $request)
    {
                        
        $validatedData = $request->validate([
        'nama_dokter' => 'required|string|max:255',
        ]);
        
        DataDokter::create($validatedData);
        
        // Redirect ke halaman sebelumnya atau halaman lain
        $dentist = DataDokter::all();
        // dd($dentist);
        return redirect()->back()->with('success', 'Data dentist berhasil disimpan.', compact('dentist'));
    }
    
    
    
    public function updateDentist(Request $request, $id)
    {
        // Validasi input jika diperlukan
        $request->validate([
            'dentistName' => 'required|string|max:255',
            // Tambahkan validasi untuk field lain yang diperlukan
        ]);
        
        // Temukan dentist berdasarkan ID
        $dentist = DataDokter::findOrFail($id);
        
        // Update data dentist
        $dentist->nama_dokter = $request->input('dentistName');
        // Update field lain jika diperlukan
        $dentist->save(); // Simpan perubahan ke database
        
        // Redirect atau berikan respon sesuai kebutuhan
        return redirect()->back()->with('success', 'Dentist updated successfully.');
    }
    
    public function hapus_data_dentist($id)
    {
        // Temukan pasien berdasarkan ID dan hapus
        $dentist = DataDokter::findOrFail($id);
        $dentist->delete();
        
        // Redirect atau response success
        return response()->json(['success' => true]);
    }
    
    
    public function export_dentist() 
    {
        return Excel::download(new Dokter, 'Data Dokter.xlsx');
    }
    
    
    public function export_data_kunjungan() 
    {
        return Excel::download(new DetailServiceExport, 'detail_service_pasiens.xlsx');

    }
    
    
    public function store_service(Request $request)
    {
        
        $validated = $request->input('service');
        
        $validatedData = $request->validate([
            'service' => 'required|string|max:255',
        ]);
        
        DataService::create($validatedData);
        
        // Redirect ke halaman sebelumnya atau halaman lain
        $service = DataService::all();
        // dd($dentist);
        return redirect()->back()->with('success', 'Data service berhasil disimpan.', compact('service'));
    }
    
    public function get_service($id)
    {

        $query = $request->input('query');
        $services = DataService::where('service', 'LIKE', "%{$query}%")->get();
        return response()->json($services);
        
    }
    
    public function updateService(Request $request, $id)
    {
        // Validasi input jika diperlukan
        $request->validate([
            'service' => 'required|string|max:255',
            // Tambahkan validasi untuk field lain yang diperlukan
        ]);
        
        // Temukan dentist berdasarkan ID
        $data_service = DataService::findOrFail($id);
        
        // Update data dentist
        $data_service->service = $request->input('service');
        // Update field lain jika diperlukan
        $data_service->save(); // Simpan perubahan ke database
        
        // Redirect atau berikan respon sesuai kebutuhan
        return redirect()->back()->with('success', 'Dentist updated successfully.');
    }
    
    public function hapus_data_service($id)
    {
        // Temukan pasien berdasarkan ID dan hapus
        $service = DataService::findOrFail($id);
        $service->delete();
        
        // Redirect atau response success
        return response()->json(['success' => true]);
    }
    
}
