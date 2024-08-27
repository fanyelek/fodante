<?php

use Illuminate\Support\Facades\Route;
use App\Models\Pasien;
use App\Http\Controllers\Admin\{AuthController};
use App\Http\Controllers\{PasienController};
use App\Http\Controllers\Admin\{ImportController};
use App\Http\Controllers\{AdminController};

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/', function () {
    return redirect()->route('dashboard-admin');
});

Route::post('/import-data-kota', [ImportController::class, 'import_data_kota'])->name('import-data-kota');
Route::post('/import-data-kunjungan', [ImportController::class, 'import_data_kunjungan'])->name('import-data-kunjungan');
Route::post('/import-data-dentis', [ImportController::class, 'import_data_dentis'])->name('import-dentis');
Route::post('/import-data-service', [ImportController::class, 'import_data_service'])->name('import.service');



//admin role
Route::get('/admin/login/',[AuthController::class, 'getlogin'])->name('getlogin');
Route::get('/admin/dashboard/', [AdminController::class, 'view_customer'])->name('dashboard-admin');
Route::get('/admin/list-dokter/',[AdminController::class, 'view_dokter'])->name('halaman-list-dokter');
Route::get('/admin/list-service/',[AdminController::class, 'view_service'])->name('halaman-list-service');
Route::get('/data-kota', [AdminController::class, 'view_data_kota'])->name('halaman-data-kota');



Route::get('/admin/analisis-umur/',[AdminController::class, 'view_analisis_umur'])->name('halaman-analisis-umur');

Route::get('/admin/analisis-dokter',[AdminController::class, 'view_analisis_dokter'])->name('halaman-analisis-dokter');
Route::get('/admin/analisis-umur/data',[AdminController::class, 'getData_analisis_dentist'])->name('analisis.dentist');

// Route::get('/analisis-service', [AdminController::class, 'view_analisis_service'])->name('analisis.service.index');
Route::get('/analisis-service/data', [AdminController::class, 'getData_analisis_service'])->name('analisis.service.data');

Route::get('/admin/analisis-service/',[AdminController::class, 'view_analisis_service'])->name('halaman-analisis-service');
Route::get('/admin/analisis-alamat/',[AdminController::class, 'view_analisis_alamat'])->name('halaman-analisis-alamat');
Route::get('/admin/analisis-kunjungan/',[AdminController::class, 'view_analisis_kunjungan'])->name('halaman-analisis-kunjungan');


Route::get('/get-patient-details/{id}', [AdminController::class, 'getPatientDetails']);
Route::delete('/patients-delete/{id}', [AdminController::class, 'hapus_data_pasien'])->name('patients.destroy');


Route::get('/search-lokasi', [AdminController::class, 'search'])->name('search.lokasi');
Route::get('/search-dentist', [AdminController::class, 'search_dentist'])->name('search-dentist');
Route::get('/search-service', [AdminController::class, 'searchService'])->name('search-service');


Route::get('/get-dentist/{id}', [AdminController::class, 'getDentist'])->name('get-dentist');
Route::put('/update-dentist/{id}', [AdminController::class, 'updateDentist'])->name('update-dentist');
Route::delete('/data-dentist-delete/{id}', [AdminController::class, 'hapus_data_dentist'])->name('dentist.destroy');
Route::post('/store-data-dentist', [AdminController::class, 'store_dentist'])->name('store.dentist');
Route::get('/export-dentist', [AdminController::class, 'export_dentist'])->name('export.dentist');


Route::post('/store-data-service', [AdminController::class, 'store_service'])->name('store.service');
Route::get('/get-service/{id}', [AdminController::class, 'get_service'])->name('get.service');
Route::put('/update-service/{id}', [AdminController::class, 'updateService'])->name('update-service');
Route::delete('/service-delete/{id}', [AdminController::class, 'hapus_data_service'])->name('services.destroy');



Route::POST('/admin/pasien/store',[PasienController::class, 'store'])->name('store-pasien');
Route::post('/detail-service-pasien', [PasienController::class, 'store_layanan_pasien'])->name('detail-service-pasien.store');
Route::get('/export-pasien', [PasienController::class, 'export'])->name('export.pasien');
Route::post('/import-pasien', [PasienController::class, 'import'])->name('import.pasien');
Route::get('/search-nama', [PasienController::class, 'searchNama']);
Route::post('/generate-norm', [PasienController::class, 'generateNorm'])->name('generate-norm');
Route::get('/pasien/{id}', [PasienController::class, 'getPasien'])->name('get-pasien');//untuk pencarian yang akan digunakan untuk edit profile pasien