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
            'lahir' => 'required|date',
            'kelurahan' => 'nullable|string|max:255',
            'kecamatan' => 'nullable|string|max:255',
            'kota' => 'nullable|string|max:255',
            'telepon' => 'required|string|max:20',
            'email' => 'required|string|email|max:255',
            'adminNote' => 'nullable|string',
            'rujukan' => 'nullable|string|max:255',
            ]);
        
            
            if (Pasien::exists()) {

                $dataTerakhir = Pasien::orderBy('id', 'desc')->first();
                $teks = $dataTerakhir->norm;
                
                function pisahkan_huruf_angka($teks) {
                    // Regular ekspresi untuk mencocokkan huruf dan angka
                    preg_match('/([a-zA-Z]+)([0-9]+)/', $teks, $matches);
                
                    // Mengembalikan hasil dalam bentuk array
                    return $matches;
                }
            
                function tambahAngkaDenganFormat($huruf, $angka, $jumlah_digit) {
                    // Ubah angka menjadi integer
                    $angka_int = (int)$angka;
                
                    // Tambahkan 1
                    $angka_int++;
                
                    // Format ulang angka menjadi string dengan jumlah digit yang ditentukan
                    $angka_baru = str_pad($angka_int, $jumlah_digit, '0', STR_PAD_LEFT);
                
                    // Gabungkan kembali huruf dan angka baru
                    return $huruf . $angka_baru;
                }
                // Contoh penggunaan
                $hasil = pisahkan_huruf_angka($teks);
                
                $huruf = $hasil[1];
                $angka = $hasil[2];

                

                $jumlah_digit = 4; // Jumlah digit yang ingin dipertahankan

                $norm = tambahAngkaDenganFormat($huruf, $angka, $jumlah_digit);

            } else {
                $norm = 'A'. '0001';

            }

            $validatedData['norm'] = $norm;
            $validatedData['age'] = $age;
            $validatedData['kunjungan'] = 0;
            
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
                'biaya' => $request->biaya[$index],
                'catatan' => $request->catatan[$index] ?? null,
            ]);
    
            // Perbarui jumlah kunjungan pasien
        }

        $pasien->kunjungan = $pasien->kunjungan + 1;
        $pasien->save();
    
        // Redirect ke halaman sebelumnya atau halaman lain
        return redirect()->back()->with('success', 'Data pasien berhasil disimpan.');
    }
}
