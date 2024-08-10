<?php

namespace App\Imports;
use Illuminate\Support\Facades\Validator;

use App\Models\DetailServicePasien;
use App\Models\Pasien;
use App\Models\DataDokter;
use App\Models\DataService;
use Maatwebsite\Excel\Concerns\ToModel;

class KunjunganImport implements ToModel
{
    public function model(array $row)
    {
        $pasien = Pasien::where('nama', $row[3])->first();


        $id_dentist = DataDokter::where('nama_dokter', $row[11])
            ->first();

        if(!$id_dentist){
            $validated = [
                'nama_dokter' => $row[11]];

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
        }


        $id_service = DataService::where('service', $row[9])
            ->first();

        if(!$id_service){
            $validated = [
                'service' => $row[9]];

                $validator = Validator::make($validated, [
                    'service' => 'required|string|max:255',
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
            DataService::create($validatedData);
        }

        $id_dentist = DataDokter::where('nama_dokter', $row[11])
            ->first();

        $id_service = DataService::where('service', $row[9])
            ->first();
        // dd($id_dentist);

        return new DetailServicePasien([
            'pasien_id' => $pasien->id,
            'dentist_id' => $id_dentist->id,
            'tanggal' => $row[1],
            'service_id' => $id_service->id,
            'biaya' => $row[10],
            'catatan' => '-',
        ]);
    }
}
