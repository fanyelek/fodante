<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\PasienImport;
use App\Exports\PasienExport;
use App\Models\Pasien;
use App\Models\DetailServicePasien;
use App\Models\DataDokter;
use App\Models\DataService;
use App\Models\Kota;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

use Illuminate\Http\Request;

class PasienController extends Controller
{
    public function store(Request $request){
        
        
        //$age
        $tanggal_lahir = Carbon::parse($request->input('lahir'));
        $age = $tanggal_lahir->age;


        $tanggal = Carbon::today()->toDateString();
        // Validasi data
        $validatedData = $request->validate([
            'nama' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'gender' => 'nullable|string|max:255',
            'lahir' => 'required|date',
            'fulladdress' => 'nullable|string|max:255',
            'telepon' => 'required|string|max:20',
            'email' => 'required|string|email|max:255',
            'adminNote' => 'nullable|string',
            'rujukan' => 'nullable|string|max:255',
            ]);
        

        $cekkota = Kota::where('nama_kota', $request->kota)->first();
        $cekkecamatan = Kecamatan::where('nama_kecamatan', $request->kecamatan)->first();
        $cekkelurahan = Kelurahan::where('nama_kelurahan', $request->kelurahan)->first();

        if(!$cekkota){

            Kota::create([
                'nama_kota' => $request->kota,
            ]);
            $cekkota = Kota::where('nama_kota', $request->kota)->first();
        }

        if(!$cekkecamatan){

            if (!empty($request->kecamatan)) {
                Kecamatan::create([
                    'nama_kecamatan' => $request->kecamatan,
                    'kota_id' => $cekkota->id,
                ]);
                $cekkecamatan = Kecamatan::where('nama_kecamatan', $request->kecamatan)->first();
            }

        }

        if(!$cekkelurahan){

            if (!empty($request->kelurahan)) {
                Kelurahan::create([
                    'nama_kelurahan' => $request->kelurahan,
                    'kecamatan_id' => $cekkecamatan->id,
                    'kota_id' => $cekkota->id,
                ]);
                
                $cekkelurahan = Kelurahan::where('nama_kelurahan', $request->kelurahan)->first();
            }
            
        }

            $validatedData['kota'] = $cekkota->nama_kota;
            
            if (!empty($request->kecamatan)) {
                $validatedData['kecamatan'] = $cekkecamatan->nama_kecamatan;
            }
            
            if (!empty($request->kelurahan)) {
                $validatedData['kelurahan'] = $cekkelurahan->nama_kelurahan;
            }

            $validatedData['norm'] = $request->norm;
            $validatedData['age'] = $age;
            
            // dd($validatedData);

            // Simpan data ke database
            Pasien::create($validatedData);
            

            // Redirect ke halaman sebelumnya atau halaman lain
            $pasien = Pasien::all();
            return redirect()->back()->with('success', 'Data pasien berhasil disimpan.', compact('pasien'));
        
    }

    public function export() 
    {
        return Excel::download(new PasienExport, 'patients.xlsx');
    }

    public function import(Request $request) 
    {
        $file = $request->file('importFile');
        Excel::import(new PasienImport, $file);
        
        $pasien = Pasien::all();
        return redirect()->back()->with('success', 'Patients imported successfully.', compact('pasien'));
    }

    public function searchNama(Request $request)
    {
        $query = $request->get('query');
        $results = Pasien::where('nama', 'LIKE', "%{$query}%")->get();
        return response()->json($results);
    }

    
    public function store_layanan_pasien(Request $request)
    {
        // dd($request);
        // Ambil pasien berdasarkan nama dan tanggal lahir
        $pasien = Pasien::where('nama', $request->nama)
            ->where('lahir', $request->lahir)
            ->first();
    
        // Ambil dokter berdasarkan nama dokter
        $dentist = DataDokter::where('nama_dokter', $request->doctor_name_input)
            ->first();
    
        // Jika dokter belum ada, tambahkan ke database
        if (!$dentist) {
            DataDokter::create([
                'nama_dokter' => $request->doctor_name_input,
            ]);
            $dentist = DataDokter::where('nama_dokter', $request->doctor_name_input)
                ->first();
        }
    
        // Loop melalui setiap service
        foreach ($request->service as $index => $service) {
            // Cek apakah service sudah ada di database
            $cekservice = DataService::where('service', $service)->first();
    
            // Jika service belum ada, tambahkan ke database
            if (!$cekservice) {
                DataService::create([
                    'service' => $service,
                ]);
                $service = DataService::where('service', $service)->first();
                $serviceId = $service->id;
            } else {
                $serviceId = $cekservice->id;
            }
    
            // Format tanggal menggunakan Carbon
            $formattedDate = Carbon::parse($request->visitDate)->format('Y-m-d');
            // Simpan detail service pasien ke database
            DetailServicePasien::create([
                'pasien_id' => $pasien->id,
                'dentist_id' => $dentist->id,
                'tanggal' => $formattedDate,
                'service_id' => $serviceId,
                'tarif' => $request->tarif[$index],
                'diskon_klinik' => $request->diskon_klinik[$index],
                'harga_bayar' => $request->harga_bayar[$index],
                'catatan' => $request->catatan[$index] ?? null,
            ]);
    
            // Perbarui jumlah kunjungan pasien
        }

    
        // Redirect ke halaman sebelumnya atau halaman lain
        return redirect()->back()->with('success', 'Data pasien berhasil disimpan.');
    }

    public function generateNorm(Request $request)
    {
        $firstLetter = strtoupper(substr($request->nama, 0, 1)); // Mengambil huruf pertama dari nama
        $latestPatient = Pasien::where('norm', 'like', $firstLetter . '%')
                            ->orderBy('norm', 'desc')
                            ->first();

        if ($latestPatient) {
            $latestNorm = $latestPatient->norm;
            $numberPart = intval(substr($latestNorm, 1)) + 1;
            $newNorm = $firstLetter . str_pad($numberPart, 3, '0', STR_PAD_LEFT);
        } else {
            $newNorm = $firstLetter . '001';
        }

        return response()->json(['norm' => $newNorm]);
    }


    public function getPasien($id)
    {
        $pasien = Pasien::findOrFail($id);
        return response()->json($pasien);
    }

    


    public function update(Request $request){
        // Validasi input
        $request->validate([
            'id' => 'required|integer|exists:pasiens,id',
            'norm' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'nama' => 'required|string|max:255',
            'lahir' => 'required|date',
            'age' => 'required|integer',
            'gender' => 'required|string|max:255',
            'kota' => 'required|string|max:255',
            'telepon' => 'required|string|max:15',
            'email' => 'required|email|max:255',
        ]);

        // Cari pasien berdasarkan ID
        $pasien = Pasien::findOrFail($request->id);

        // Update data pasien
        $pasien->norm = $request->norm;
        $pasien->tanggal = $request->tanggal;
        $pasien->nama = $request->nama;
        $pasien->lahir = $request->lahir;
        $pasien->age = $request->age;
        $pasien->gender = $request->gender;
        $pasien->kelurahan = $request->kelurahan;
        $pasien->kecamatan = $request->kecamatan;
        $pasien->kota = $request->kota;
        $pasien->telepon = $request->telepon;
        $pasien->email = $request->email;
        $pasien->fulladress = $request->fulladress;
        $pasien->adminNote = $request->adminNote;
        $pasien->rujukan = $request->rujukan;

        // Simpan perubahan
        $pasien->save();

        // Redirect atau response sesuai kebutuhan
        return redirect()->back()->with('success', 'Data pasien berhasil diperbarui.');
    

    }
    
}
