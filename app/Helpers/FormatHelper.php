<?php

namespace App\Helpers;

class FormatHelper
{
    public static function formatRupiah($angka)
    {
        return 'Rp. ' . number_format($angka, 0, ',', '.');
    }

    
    public static function tambahAngkaDenganFormat($huruf, $angka, $jumlah_digit) {
        // Ubah angka menjadi integer
        $angka_int = (int)$angka;
    
        // Tambahkan 1
        $angka_int++;
    
        // Format ulang angka menjadi string dengan jumlah digit yang ditentukan
        $angka_baru = str_pad($angka_int, $jumlah_digit, '0', STR_PAD_LEFT);
    
        // Gabungkan kembali huruf dan angka baru
        return $huruf . $angka_baru;
    }

    public static function pisahkan_huruf_angka($teks) {
        // Regular ekspresi untuk mencocokkan huruf dan angka
        preg_match('/([a-zA-Z]+)([0-9]+)/', $teks, $matches);
    
        // Mengembalikan hasil dalam bentuk array
        return $matches;
    }
}