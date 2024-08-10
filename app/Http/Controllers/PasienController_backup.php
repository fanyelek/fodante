<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\PasienImport;
use App\Exports\PasienExport;
use App\Models\Pasien;
use App\Models\DetailServicePasien;
use App\Models\DataDokter;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

use Illuminate\Http\Request;

class PasienController extends Controller
{
    public function store(Request $request){
        
        $nama = $request->input('nama');
        $tanggal_lahir = $request->input('lahir');
        
        $pasien = Pasien::where('nama', $nama)
        ->where('lahir', $tanggal_lahir)
        ->first();
        
        
        // $norm = $request->input('norm');
        $tanggal = $request->input('tanggal');
        // $kunjungan
        $nama = $request->input('nama');
        $tanggal_lahir = $request->input('lahir');
        
        //$age
        $tanggal_lahir = Carbon::parse($request->input('lahir'));
        $age = $tanggal_lahir->age;

        $alamat = $request->input('alamat');
        $telepon = $request->input('telepon');
        $email = $request->input('email');
        $catatan = $request->input('adminNote');
        $rujukan = $request->input('rujukan');
        

        $dokter = $request->input('dokter');
        //array (multiple input)
        $service = $request->service;
        $biaya = $request->biaya;
        $biaya = $request->catatan;


        if ($pasien) {
            // Jika data ditemukan, update data tersebut
            $pasien->kunjungan = $pasien->kunjungan + 1 ;
            $pasien->telepon = $telepon;
            $pasien->email = $email;
            $pasien->adminNote = $catatan;
            $pasien->rujukan = $rujukan;
            $pasien->save();

            $id_pasien = Pasien::where('nama', $nama)
            ->where('lahir', $tanggal_lahir)
            ->first();

            $data_dokter = DataDokter::where('nama_dokter', $dokter)
            ->first();  

            $id_dentist;

            if($data_dokter){

                $id_dentist = $data_dokter->id;
            
            }else{                

                $validated = [

                    'nama_dokter' => $request->input('dokter')
                
                ];
    
                    $validator = Validator::make($validated, [
                        'nama_dokter' => 'required|string|max:255',
                    ]);
                    // Periksa apakah validasi gagal
                if ($validator->fails()) {
                    // Tangani kesalahan validasi (misalnya, lempar pengecualian atau lanjutkan dengan pesan kesalahan)
                    // return atau lempar pengecualian jika diperlukan
                    throw new \Illuminate\Validation\ValidationException($validator);
                }
    
                // Dapatkan data yang telah divalidasi
                $validatedData = $validator->validated();
    
                // Buat entri baru di tabel DataDokter
                DataDokter::create($validatedData);

                $data_dokter = DataDokter::where('nama_dokter', $dokter)
                ->first();

                $id_dentist = $data_dokter->id;

            }
             

            foreach ($request->service as $index => $service) {
                DetailServicePasien::create([
                    'pasien_id' => $id_pasien->id,
                    'dentist_id' => $id_dentist,
                    'tanggal' => $request->tanggal,
                    'service' => $service,
                    'biaya' => $request->biaya[$index],
                    'catatan' => $request->catatan[$index] ?? null,
                ]);
            }


            // $data_service = ([
            //     'tanggal' => $tanggal,
            //     'service' => $service,
            //     'biaya' => $biaya,
            //     'dokter' => 'dokter 1',
            //     'pasien_id' => $id_pasien->id ]);
            //     DetailServicePasien::create($data_service);

            $pasien = Pasien::all();
            return redirect()->back()->with('success', 'Data pasien berhasil disimpan.', compact('pasien'));

        }else{

        // Validasi data
        $validatedData = $request->validate([
            'tanggal' => 'required|date',
            'nama' => 'required|string|max:255',
            'lahir' => 'required|date',
            'kelurahan' => 'required|string|max:255',
            'kecamatan' => 'required|string|max:255',
            'kota' => 'required|string|max:255',
            'telepon' => 'required|string|max:20',
            'email' => 'required|string|email|max:255',
            'adminNote' => 'nullable|string',
            'rujukan' => 'nullable|string|max:255',
            ]);


        // $validatedData = $request->validate([
        //     'tanggal' => 'required|date',
        //     'nama' => 'required|string|max:255',
        //     'lahir' => 'required|date',
        //     'alamat' => 'required|string|max:255',
        //     'telepon' => 'required|string|max:20',
        //     'email' => 'required|string|email|max:255',
        //     'service' => 'required|string|max:255',
        //     'biaya' => 'required|numeric',
        //     'catatan' => 'nullable|string',
        //     'rujukan' => 'nullable|string|max:255',
        //     ]);

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
            $validatedData['kunjungan'] = 1;

            // Simpan data ke database
            Pasien::create($validatedData);

            $id_pasien = Pasien::where('nama', $nama)
                ->where('lahir', $tanggal_lahir)
                ->first();

            $id_dentist = DataDokter::where('nama_dokter', $dokter)
            ->first();

            if(!$id_dentist){
                
                $validated = $request->input('dokter');
                // dd($validated);
                $validatedData = $request->validate([
                    'nama_dokter' => 'required|string|max:255',
                ]);
        
                DataDokter::create($validatedData);
            }

            // $data_service = ([
            //     'pasien_id' => $id_pasien->id,
            //     'dentist_id' => $id_dentist->id,
            //     'tanggal' => $tanggal,
            //     'service' => $service,
            //     'biaya' => $biaya,
            //     'catatan' => $catatan]);
            //     DetailServicePasien::create($data_service);

            foreach ($request->service as $index => $service) {
                DetailServicePasien::create([
                    'pasien_id' => $id_pasien->id,
                    'dentist_id' => $id_dentist->id,
                    'tanggal' => $request->tanggal,
                    'service' => $service,
                    'biaya' => $request->biaya[$index],
                    'catatan' => $request->catatan[$index] ?? null,
                ]);
            }

            // Redirect ke halaman sebelumnya atau halaman lain
            $pasien = Pasien::all();
            return redirect()->back()->with('success', 'Data pasien berhasil disimpan.', compact('pasien'));
        }
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

    
}
