
@extends('template-dashboard')
 @section('dashboard')
 <meta name="csrf-token" content="{{ csrf_token() }}">

                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif


                    <div class="card shadow mb-2">
                                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                                    <h6 class="m-0 font-weight-bold text-primary">Pasien Dante</h6>
                                    <div class="d-flex ml-auto">
                                        <button class="btn btn-success ml-2 mr-4" data-toggle="modal" data-target="#addPatientModal" style="font-size: 14px">Tambah Data</button>

                                        <div class="separator"></div>

                                        <style>
                                            .separator {
                                                border-left: 1px solid #d1d1d1; /* Warna garis samar */
                                                height: 30px; /* Tinggi garis, sesuaikan dengan kebutuhan */
                                                margin: 0 10px; /* Jarak kiri dan kanan garis */
                                                margin-top: 5px;
                                                display: inline-block; /* Agar elemen tampil sejajar dengan tombol */
                                            }

                                            #addPatientModal ::placeholder, #addCustomerModal ::placeholder {
                                                color: rgba(0, 0, 0, 0.5); /* Mengatur warna font placeholder menjadi hitam dengan opacity 40% */
                                                font-size: 14px;
                                            }

                                            .custom-form .form-control {
                                                background-color: #f8f8f8; /* Warna putih sedikit abu-abu */
                                                border: 1px solid #ddd; /* Warna border */
                                                color: #333; /* Warna teks */
                                            }





                                            /* style untuk customer start */

                                            .suggestions-list {
                                                display: flex;
                                                flex-direction: column;
                                            }

                                            .suggestion-item {
                                                padding: 8px;
                                                border-bottom: 1px solid #ddd; /* Garis pembatas samar */
                                                display: flex;
                                                flex-direction: column; /* Membuat flex-direction menjadi column untuk menyusun nama di atas dan dua kolom di bawahnya */
                                                box-sizing: border-box; /* Menggunakan box-sizing untuk memastikan border dan padding termasuk dalam lebar */
                                            }

                                            .suggestion-item:last-child {
                                                border-bottom: none; /* Menghapus garis pembatas untuk item terakhir */
                                            }

                                            .suggestion-columns {
                                                display: flex;
                                                justify-content: space-between;
                                            }

                                            .suggestion-column {
                                                width: 48%; /* Mengatur lebar kolom menjadi 48% untuk dua kolom dengan sedikit jarak di antaranya */
                                            }

                                            .suggestion-name {
                                                font-weight: bold;
                                                margin-bottom: 5px;
                                            }
                                            
                                            .detail-customer {
                                                background-color: #f8f8f8; /* Warna putih sedikit abu-abu */
                                                margin-top: -18px; /* Jarak antara input pencarian dan detail customer */
                                                margin-bottom: 20px;
                                                padding: 10px;
                                                border: 1px solid #ddd; /* Garis border merah */
                                                border-radius: 5px;
                                            }

                                            .detail-customer-title {
                                                font-weight: bold;
                                                margin-bottom: 10px;
                                            }

                                            .detail-customer-content {
                                                display: flex;
                                                justify-content: space-between;
                                            }

                                            .detail-customer-column {
                                                width: 48%;
                                            }

                                            /* style untuk customer end */
                                            
                                            


                                            /* style untuk service start */

                                            .service-suggestions {
                                                border: 1px solid #ddd;
                                                background: #fff;
                                                max-height: 200px;
                                                overflow-y: auto;
                                                position: absolute;
                                                z-index: 1000;
                                                width: calc(35%); /* Menyesuaikan dengan lebar input */
                                                box-sizing: border-box;
                                            }

                                            .suggestion-item-service {
                                                padding: 8px;
                                                cursor: pointer;
                                                border-bottom: 1px solid #ddd; /* Garis pembatas samar */
                                            }

                                            .suggestion-item-service:last-child {
                                                border-bottom: none;
                                            }

                                            /* style untuk service end */



                                            /* untuk search alamat tambah pasien */
                                            .custom-form .search-input {
                                                background-color: #fff; /* Warna latar belakang berbeda */
                                                border: 1px dashed #fff; /* Border berbeda */
                                                color: #495057;
                                            }

                                            .custom-form .search-input::placeholder {
                                                font-style: italic; /* Placeholder dengan gaya miring */
                                                color: #6c757d;
                                            }

                                            .search-wrapper {
                                                background-color: #f1f1f1; /* Warna latar belakang untuk wrapper */
                                                padding: 10px;
                                                border-radius: 5px;
                                            }
                                        </style>


                                    <div class="dropdown no-arrow ml-2" style="margin-top: 11px">
                                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                                            aria-labelledby="dropdownMenuLink">
                                            <div class="dropdown-header">Action:</div>
                                            <a class="dropdown-item" data-toggle="modal" data-target="#exportModal">Export Data Pasien</a>
                                            <a class="dropdown-item" data-toggle="modal" data-target="#importModal">Import Data Pasien</a>
                                            <a class="dropdown-item" data-toggle="modal" data-target="#importModalDetail">Import Visitasi Pasien</a>
                                        </div>
                                    </div>
                                    <!-- <button class="btn btn-success ml-2" data-toggle="modal" data-target="#exportModal">Export</button> -->
                                    <!-- <button class="btn btn-success ml-2" data-toggle="modal" data-target="#importModal">Import</button> -->
                                    <!-- <button class="btn btn-success ml-2" data-toggle="modal" data-target="#importModalDetail">Import Detail Kunjungan</button> -->
                                    </div>
                                </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0" style="font-size: 12px">
                                            <thead>
                                                <tr>
                                                    <th class="align-middle text-center">No.</th>
                                                    <th class="align-middle text-center">No. Rekam Medis</th>
                                                    <th class="align-middle text-center">Tanggal Ditambah</th>
                                                    <th class="align-middle text-center">Nama</th>
                                                    <th class="align-middle text-center">Jumlah Layanan</th>
                                                    <th class="align-middle text-center">Alamat</th>
                                                    <th class="align-middle text-center">Action</th>
                                                </tr>
                                            </thead>
                                            <tfoot>
                                                <tr>
                                                    <th class="align-middle text-center">No.</th>
                                                    <th class="align-middle text-center">No. Rekam Medis</th>
                                                    <th class="align-middle text-center">Tanggal Ditambah</th>
                                                    <th class="align-middle text-center">Nama</th>
                                                    <th class="align-middle text-center">Jumlah Kunjungan</th>
                                                    <th class="align-middle text-center">Alamat</th>
                                                    <th class="align-middle text-center">Action</th>
                                                </tr>
                                            </tfoot>
                                            <tbody>
                                                @php
                                                    $counter = $pasien->count(); // Menghitung jumlah total pasien
                                                @endphp
                                                @foreach($pasien as $pasiens)
                                                <tr>
                                                    <td class="align-middle text-center">{{ $counter-- }}</td>
                                                    <td class="align-middle text-center">{{ $pasiens->norm }}</td>
                                                    <td class="align-middle text-center">{{ \Carbon\Carbon::parse($pasiens->created_at)->format('d-m-Y') }}</td>
                                                    <td class="align-middle">{{ $pasiens->nama }}</td>
                                                    <td class="align-middle text-center">{{ $pasiens->detail_service_pasiens_count }}</td>
                                                    <td class="align-middle">{{ implode(', ', array_filter([$pasiens->kelurahan, $pasiens->kecamatan, $pasiens->kota])) }}</td>
                                                    <td class="align-middle">
                                                    <div class="d-flex ml-auto">
                                                        <button style="font-size: 12px" class="btn btn-success ml-2 detail-btn" data-toggle="modal" data-target="#patientDetailModal" data-id="{{ $pasiens->id }}">Detail</button>                                  
                                                        <button style="font-size: 12px" class="btn btn-danger ml-2 delete-btn" data-toggle="modal" data-id="{{ $pasiens->id }}">Delete</button>
                                                    </div>
                                                    </td>
                                                </tr>    
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                    
                        <!-- Star Modal Tambah Pasien-->
                        
                        <div class="modal fade" id="addPatientModal" tabindex="-1" role="dialog" aria-labelledby="addPatientModalLabel" aria-hidden="true">
                            <div class="modal-dialog custom-modal-sedang" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title text-primary m-0 font-weight-bold" style="font-size: 18px" id="addPatientModalLabel">Tambah Perawatan/Layanan/Tindakan</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="container">
                                            <form class="custom-form" id="patientForm" method="POST" action="{{ route('detail-service-pasien.store') }}">
                                            @csrf

                                            <!-- hiden form -->
                                            <input type="hidden" name="norm" id="hiddenNorm">
                                            <input type="hidden" name="nama" id="hiddenNama">
                                            <input type="hidden" name="lahir" id="hiddenLahir">
                                            <input type="hidden" name="email" id="hiddenEmail">
                                            <input type="hidden" name="telepon" id="hiddenTelepon">
                                            <input type="hidden" name="alamat" id="hiddenAlamat">
                                            <input type="hidden" name="tanggal" id="hiddenTanggal">

                                            <!-- end hiden form -->


                                                <div class="form-group">
                                                    <label for="customerName" style="color: black">Nama Pasien</label>
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" id="searchPatient" placeholder="Masukkan nama yang ingin dicari" required autocomplete="off">
                                                        <div class="input-group-append">
                                                            <button type="button" class="btn btn-primary add-customer-btn" data-toggle="modal" data-target="#addCustomerModal"><i class="fas fa-plus"></i> Pasien Baru</button>
                                                        </div>
                                                    </div>
                                                    <div id="namaSuggestions" class="suggestions-list"></div>
                                                </div>
                                                <div id="customerDetail"></div>
                                                <div class="form-row">
                                                    <div class="form-group col-md-6">
                                                        <label for="visitDate" style="color: black">Tanggal Kunjungan</label>
                                                        <input type="date" class="form-control" name="visitDate" id="visitDate" value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" required autocomplete="off"> 
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label for="doctorName" style="color: black">Nama Dentist</label>
                                                        <select class="form-control" id="doctorNameSelect" name="nama_dokter" placeholder="Pilih Dentist..." required autocomplete="off">
                                                            <option value="" disabled selected>Pilih Dentist...</option>
                                                        </select>
                                                        <input type="text" class="form-control d-none" id="doctorNameInput" name="doctor_name_input" placeholder="Masukkan nama dokter" required autocomplete="off">
                                                        <div id="doctorSuggestions" class="suggestions-list"></div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="service" style="color: black">Detail Service</label>
                                                    <div id="service-container">
                                                        <div class="input-group">
                                                            <input type="text" class="form-control service-name" name="service[]" placeholder="Masukkan Service" autocomplete="off" required autocomplete="off">
                                                            <input type="number" class="form-control service-cost" name="tarif[]" placeholder="Tarif" required autocomplete="off">
                                                            <input type="text" class="form-control service-diskon" name="diskon_klinik[]" value="0" autocomplete="off">
                                                            <input type="text" class="form-control service-bayar" name="harga_bayar[]" placeholder="Harga Bayar" autocomplete="off">
                                                            <div class="input-group-append">
                                                                <button type="button" class="btn btn-primary add-service-btn">+</button>
                                                            </div>
                                                        </div>
                                                        <div class="service-suggestions suggestions-list"></div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                    <button type="button" class="btn btn-danger" id="resetFormBtn">Reset Form</button>
                                                    <button type="submit" class="btn btn-success">Save changes</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <!-- End of Modal -->

                        <!-- Modal Tambah Customer Start -->

                        <div class="modal fade" id="addCustomerModal" tabindex="-1" role="dialog" aria-labelledby="addCustomerModalLabel" aria-hidden="true">
                            <div class="modal-dialog custom-modal-sedang" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title text-primary m-0 font-weight-bold" style="font-size: 18px" id="addCustomerModalLabel">Tambah Pasien/Registrasi Pasien</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="container">
                                            <form action="{{ route('store-pasien') }}" method="POST" id="customerForm" class="custom-form">
                                                @csrf
                                                <div class="row">
                                                    <div class="col-md-6" style="margin-top: 11px;">
                                                        <div class="form-group">
                                                            <label for="namaCustomer" style="color: black">Nama Pasien</label>
                                                            <span style="font-size: 18px; font-weight: 500; color: red">ⓘ</span>
                                                            <input type="text" name="nama" class="form-control" id="namaCustomer" placeholder="Masukkan Nama" required autocomplete="off">
                                                            @error('nama')
                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="gender" style="color: black">Jenis Kelamin</label>
                                                            <span style="font-size: 18px; font-weight: 500; color: red">ⓘ</span>
                                                            <select name="gender" id="gender" class="form-control" required>
                                                                <option value="">Pilih Jenis Kelamin</option>
                                                                <option value="laki-laki">Laki-Laki</option>
                                                                <option value="perempuan">Perempuan</option>
                                                                <option value="tidak-disebutkan">Tidak disebutkan</option>
                                                            </select>
                                                            @error('gender')
                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                        </div>

                                                        <div class="form-group" style="margin-top: 0px;">
                                                            <label for="tanggalLahir" style="color: black">Tanggal Lahir</label>
                                                            <span style="font-size: 18px; font-weight: 500; color: red">ⓘ</span>
                                                            <input type="date" name="lahir" class="form-control" id="tanggalLahir" required autocomplete="off">
                                                            @error('lahir')
                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="email" style="color: black">Email</label>
                                                            <span style="font-size: 18px; font-weight: 500; color: red">ⓘ</span>
                                                            <input type="email" name="email" class="form-control" id="email" placeholder="Masukkan Email" required autocomplete="off">
                                                            @error('email')
                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="noTelepon" style="color: black">No. Telepon</label>
                                                            <span style="font-size: 18px; font-weight: 500; color: red">ⓘ</span>
                                                            <input type="tel" name="telepon" class="form-control" id="noTelepon" placeholder="Masukkan No. Telepon" required autocomplete="off">
                                                            @error('telepon')
                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="rujukan" style="color: black">Rujukan</label autocomplete="off">                                                            
                                                            <span style="font-size: 14px; font-weight: 500; color: rgba(0, 0, 0, 0.5)">(Optional)</span>
                                                            <input type="text" name="rujukan" class="form-control" id="rujukan" placeholder="Masukkan Rujukan">
                                                            @error('rujukan')
                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div style="background-color: rgba(0, 0, 0, 0.05); padding-right: px; padding-left: px; padding-bottom: px; border-radius: 5px">
                                                            <div class="form-group search-wrapper bg-primary text-white">
                                                                <label for="alamat">Cari Alamat</label>
                                                                <div class="input-group">
                                                                    <input type="text" name="alamat" class="form-control search-input" id="alamat" placeholder="Cari alamat" autocomplete="off">
                                                                    <div class="input-group-append">
                                                                        <span class="input-group-text"><i class="fas fa-search"></i></span>
                                                                    </div>
                                                                </div>
                                                                <div id="alamatSuggestions" class="suggestions-list"></div>
                                                            </div>
                                                            <div class="form-group" style="margin-top: -5px;">
                                                                <label for="fulladress" style="color: black; margin-left: 10px">Alamat Lengkap</label>
                                                                <span style="font-size: 18px; font-weight: 500; color: red">ⓘ</span>
                                                                <input style="margin-left: 5px; margin-right: 5px; width: calc(100% - 10px); box-sizing: border-box; background-color: white;" type="text" name="fulladress" class="form-control" id="fulladress" placeholder="Alamat lengkap" required autocomplete="off">
                                                                @error('fulladress')
                                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                                @enderror
                                                            </div>
                                                            <div class="form-group" style="margin-top: 14px;">
                                                                <label for="kota" style="color: black; margin-left: 10px">Kota</label>
                                                                <span style="font-size: 18px; font-weight: 500; color: red">ⓘ</span>
                                                                <input style="margin-left: 5px; margin-right: 5px; width: calc(100% - 10px); box-sizing: border-box; background-color: white;" type="text" name="kota" class="form-control" id="kota" placeholder="Kota" required autocomplete="off">
                                                                @error('kota')
                                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                                @enderror
                                                            </div>
                                                            <div class="form-group" style="margin-top: 19px;">
                                                                <label for="kecamatan" style="color: black; margin-left: 10px">Kecamatan</label>
                                                                <span style="font-size: 14px; font-weight: 500; color: rgba(0, 0, 0, 0.5)">(Optional)</span>
                                                                <input style="margin-left: 5px; margin-right: 5px; width: calc(100% - 10px); box-sizing: border-box; background-color: white;" type="text" name="kecamatan" class="form-control" id="kecamatan" placeholder="Kota/Kecamatan" autocomplete="off">
                                                                @error('kecamatan')
                                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="catatanAdmin" style="color: black">Catatan Admin</label>
                                                            <span style="font-size: 14px; font-weight: 500; color: rgba(0, 0, 0, 0.5)">(Optional)</span>
                                                            <input type="text" name="adminNote" class="form-control" id="catatanAdmin" placeholder="Masukkan Catatan Admin" autocomplete="off">
                                                            @error('adminNote')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                        <div class="form-group row">
                                                            <div class="col-md-6">
                                                                <label for="tanggal" style="color: black">Tanggal Ditambah</label>
                                                                <span style="font-size: 18px; font-weight: 500; color: red">ⓘ</span>
                                                                <input type="date" name="tanggal" class="form-control" id="tanggal" value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" autocomplete="off">
                                                                @error('tanggal')
                                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                                @enderror
                                                            </div>

                                                            <div class="form-group col-md-6">
                                                                <label for="norm" style="color: black">No Rekam Medis</label>
                                                                <span style="font-size: 18px; font-weight: 500; color: red">ⓘ</span>
                                                                <input type="text" name="norm" placeholder="No Rekam Medis" class="form-control" id="norm" autocomplete="off">
                                                                @error('norm')
                                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                    <button type="button" class="btn btn-danger" id="resetCustomerFormBtn">Reset Form</button>
                                                    <button type="submit" class="btn btn-success">Save changes</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Modal Tambah Customer End -->

                        <!-- Start Modal Import -->

                        <div class="modal fade" id="importModal" tabindex="-1" role="dialog" aria-labelledby="importModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="importModalLabel">Import Data Pasien</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form action="{{ route('import.pasien') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label for="importFile">Pilih file untuk diimport</label>
                                                <input type="file" class="form-control-file" id="importFile" name="importFile" required>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Import</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                         <!-- End Modal Import -->

                        <!-- Start Modal Import Detail Kunjungan -->

                        <div class="modal fade" id="importModalDetail" tabindex="-1" role="dialog" aria-labelledby="importModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="importModalLabel">Import Data Visitasi Pasien</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form method="POST" action="{{ route('import-data-kunjungan') }}"  enctype="multipart/form-data">
                                        @csrf
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label for="importFileKunjungan">Pilih file untuk diimport</label>
                                                <input type="file" class="form-control-file" id="importFileKunjungan" name="detail_service_file" required>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Import</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                         <!-- End Modal Import Kunjungan -->

                         <!-- Start Modal Export -->

                         <div class="modal fade" id="exportModal" tabindex="-1" role="dialog" aria-labelledby="exportModallLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exportModallLabel">Export Data Pasien</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                        <div class="modal-body">
                                                <label>Anda yakin untuk mengeksport Data Pasien?</label>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            <a href="{{ route('export.pasien') }}"><button type="button" class="btn btn-primary">Export</button></a>
                                        </div>
                                </div>
                            </div>
                        </div>

                         <!-- End Modal Import -->

                         <!-- Modal Detail Start  -->

                         <div class="modal fade" id="patientDetailModal" tabindex="-1" role="dialog" aria-labelledby="patientDetailModalLabel" aria-hidden="true">
                            <div class="modal-dialog custom-modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="patientDetailModalLabel">Detail Pasien</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <!-- Card for Patient Details -->
                                        <div class="card mb-4">
                                            <div class="card-header">
                                                <h6 class="m-0 font-weight-bold text-primary">Data Pasien</h6>
                                            </div>
                                            <div class="card-body">
                                                <table class="table table-bordered" id="patientDetailTable" width="100%" cellspacing="0" style="font-size: 12px">
                                                    <thead>
                                                        <tr>
                                                            <th class="align-middle text-center">No.</th>
                                                            <th class="align-middle text-center">No. Rekam Medis</th>
                                                            <th class="align-middle text-center">Nama</th>
                                                            <th class="align-middle text-center">Gender</th>
                                                            <th class="align-middle text-center">Umur</th>
                                                            <th class="align-middle text-center">Alamat</th>
                                                            <th class="align-middle text-center">Tanggal Lahir</th>
                                                            <th class="align-middle text-center">Email</th>
                                                            <th class="align-middle text-center">No Telepon</th>
                                                            <th class="align-middle text-center">Rujukan</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <!-- Card for Service Details -->
                                        <div class="card">
                                            <div class="card-header">
                                                <h6 class="m-0 font-weight-bold text-primary">Tabel Service</h6>
                                            </div>
                                            <div class="card-body">
                                                <table class="table table-bordered" id="serviceDetailTable" width="100%" cellspacing="0" style="font-size: 12px">
                                                    <thead>
                                                        <tr>
                                                            <th class="align-middle text-center">No</th>
                                                            <th class="align-middle text-center">Tanggal Visitasi</th>
                                                            <th class="align-middle text-center">Service</th>
                                                            <th class="align-middle text-center">Biaya</th>
                                                            <th class="align-middle text-center">Dentist</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <style>

                            .custom-modal-lg {
                                max-width: 80%; /* Set to the percentage or pixel width you want */
                            }

                            .custom-modal-sedang {
                                max-width: 60%; /* Set to the percentage or pixel width you want */
                            }

                        </style>

                         <!-- End Modal Detail  -->

                         <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                         <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
                         <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
                        


                         <!-- script modal tambah pasien start -->
                         
                        <script>
                        $(document).ready( function() {
                            $('#dataTable').dataTable( {
                            "order": []
                            } );
                        } );

                        $(document).ready(function() {
                        // Set CSRF token for all AJAX requests
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });

                        // Fungsi untuk menampilkan saran pencarian nama pasien
                        $('#searchPatient').on('input', function() {
                            let query = $(this).val();

                            if (query.length > 1) {
                                $.ajax({
                                    url: '/search-nama',
                                    method: 'GET',
                                    data: { query: query },
                                    success: function(data) {
                                        let suggestions = data.map(function(item) {
                                            let formattedDate = moment(item.created_at).format('DD-MM-YYYY'); // Format tanggal
                                            return `<div class="suggestion-item" 
                                                    data-norm="${item.norm}"
                                                    data-nama="${item.nama}"
                                                    data-gender="${item.gender}"
                                                    data-lahir="${item.lahir}"
                                                    data-email="${item.email}"
                                                    data-telepon="${item.telepon}"
                                                    data-kelurahan="${item.kelurahan}"
                                                    data-kecamatan="${item.kecamatan}"
                                                    data-kota="${item.kota}"
                                                    data-tanggal="${formattedDate}">
                                                    <div class="suggestion-name">${item.nama}</div>
                                                    <div class="suggestion-columns">
                                                        <div class="suggestion-column">
                                                            No. Rekam Medis: ${item.norm}<br>
                                                            Tanggal Lahir: ${item.lahir}<br>
                                                            Email: ${item.email}
                                                        </div>
                                                        <div class="suggestion-column">
                                                            No Telepon: ${item.telepon}<br>
                                                            Alamat: ${[item.kelurahan, item.kecamatan, item.kota].filter(Boolean).join(', ')}<br>
                                                            Tanggal Ditambah: ${formattedDate}
                                                        </div>
                                                    </div>
                                                    </div>`;
                                        }).join('');
                                        $('#namaSuggestions').html(suggestions).show();
                                        
                                    }
                                });
                            } else {
                                $('#namaSuggestions').empty().hide();
                            }
                        });

                        // Event handler untuk memilih saran nama pasien
                        $(document).on('click', '.suggestion-item', function() {
                            let selectedName = $(this).data('nama');
                            let gender = $(this).data('gender');
                            let norm = $(this).data('norm');
                            let lahir = $(this).data('lahir');
                            let email = $(this).data('email');
                            let telepon = $(this).data('telepon');
                            let kelurahan = $(this).data('kelurahan');
                            let kecamatan = $(this).data('kecamatan');
                            let kota = $(this).data('kota');
                            let tanggal = $(this).data('tanggal');

                            $('#customerDetail').html(`
                                <div class="detail-customer">
                                    <div class="detail-customer-title">Detail Customer</div>
                                    <div class="detail-customer-content">
                                        <div class="detail-customer-column">
                                            No Rekam Medis: <span style="color: red">${norm}</span><br>
                                            Nama: <span style="color: red">${selectedName}</span><br>
                                            Tanggal Lahir: <span style="color: red">${lahir}</span><br>
                                            Email: <span style="color: red">${email}</span>
                                        </div>
                                        <div class="detail-customer-column">
                                            No Telepon: <span style="color: red">${telepon}</span><br>
                                            Alamat: <span style="color: red">${[kelurahan, kecamatan, kota].filter(Boolean).join(', ')}</span><br>
                                            Tanggal Ditambah: <span style="color: red">${tanggal}</span>
                                        </div>
                                    </div>
                                </div>
                            `).show();
                            $('#hiddenNorm').val(norm);
                            $('#hiddenNama').val(selectedName);
                            $('#hiddenLahir').val(lahir);
                            $('#hiddenEmail').val(email);
                            $('#hiddenTelepon').val(telepon);
                            $('#hiddenAlamat').val([kelurahan, kecamatan, kota].filter(Boolean).join(', '));
                            $('#hiddenTanggal').val(tanggal);

                            // Mengosongkan dan menyembunyikan saran pencarian setelah memilih
                            $('#namaSuggestions').empty().hide();
                        });

                        // Fungsi untuk menampilkan saran pencarian nama dokter
                        $('#doctorNameSelect').on('click', function() {
                            $.ajax({
                                url: '{{ route("search-dentist") }}', // URL untuk route pencarian dokter
                                method: 'GET', // Metode HTTP yang digunakan
                                success: function(data) {
                                    let suggestions = data.map(function(item) {
                                        return `<option value="${item.nama_dokter}">${item.nama_dokter}</option>`;
                                    }).join('');
                                    suggestions += `<option value="other">Other Dentist...</option>`;
                                    $('#doctorNameSelect').html(`<option value="" disabled selected>Pilih Dentist...</option>` + suggestions).show();
                                }
                            });
                        });

                        // Event handler untuk memilih saran nama dokter atau memasukkan dokter baru
                        $(document).on('change', '#doctorNameSelect', function() {
                            let selectedOption = $(this).val();
                            if (selectedOption === "other") {
                                $(this).addClass('d-none');
                                $('#doctorNameInput').removeClass('d-none').val('').focus();
                            } else {
                                $('#doctorNameSelect option:selected').each(function() {
                                    $('#doctorNameInput').val($(this).val()).removeClass('d-none');
                                    $('#doctorNameSelect').addClass('d-none');
                                    $('.service-suggestions').empty().hide();
                                    $('#namaSuggestions').empty().hide();  
                                });
                            }
                        });

                        // Sembunyikan saran ketika klik di luar saran
                        $(document).click(function(e) {
                            if (!$(e.target).closest('#namaSuggestions, #searchPatient').length) {
                                $('#namaSuggestions').empty().hide();
                            }
                        });

                        // Reset form
                        $('#resetFormBtn').click(function() {
                            $('input, textarea').removeAttr('readonly');
                            $('#patientForm')[0].reset();

                            $('#doctorNameSelect').removeClass('d-none').val('');
                            $('#doctorNameInput').addClass('d-none').val('');
                            $('#customerDetail').empty().hide();

                            $('#service-container').html(`
                                <div class="input-group">
                                    <input type="text" class="form-control service-name mt-4" name="service[]" placeholder="Masukkan Service" autocomplete="off" required autocomplete="off">
                                    <input type="number" class="form-control service-cost mt-4" name="tarif[]" placeholder="Tarif" required autocomplete="off">
                                    <input type="text" class="form-control service-diskon mt-4" name="diskon_klinik[]" placeholder="Diskon Klinik" autocomplete="off">
                                    <input type="text" class="form-control service-bayar mt-4" name="harga_bayar[]" placeholder="Harga Bayar" autocomplete="off">
                                    <div class="input-group-append">
                                        <button type="button" class="btn btn-primary add-service-btn mt-4">+</button>
                                    </div>
                                </div>
                                <div class="service-suggestions suggestions-list"></div>
                            `);
                        });

                        // Event handler untuk tombol "+ Customer"
                        $('#addCustomerBtn').click(function() {
                            // Logika untuk menambahkan customer baru
                            // Contoh: Menampilkan modal untuk input data customer baru
                            alert('Tambah Customer baru!');
                        });

                    });
                    </script>
                         
                         <!-- script modal tambah pasien end -->




                         <!-- script modal detail pasien start -->

                        <script>
                        $(document).ready(function() {
                        $('#dataTable').on('click', '.detail-btn', function() {
                            let patientId = $(this).data('id');

                            $.ajax({
                                url: '/get-patient-details/' + patientId,
                                method: 'GET',
                                success: function(response) {
                                    let patient = response.pasien;
                                    let services = response.services;
                                    
                                    let patientDetailTable = $('#patientDetailTable tbody');
                                    let serviceDetailTable = $('#serviceDetailTable tbody');
                                    let kelurahan = response.pasien.kelurahan;
                                    let kecamatan = response.pasien.kecamatan;
                                    let kota = response.pasien.kota;
                                    
                                    // Clear previous data
                                    patientDetailTable.empty();
                                    serviceDetailTable.empty();
                                    
                                    // Populate patient details
                                    patientDetailTable.append(`
                                        <tr>
                                            <td class="align-middle text-center">${patient.id}</td>
                                            <td class="align-middle text-center">${patient.norm}</td>
                                            <td>${patient.nama}</td>
                                            <td>${patient.gender}</td>
                                            <td class="align-middle text-center">${patient.age}</td>
                                            <td class="align-middle text-center">${[kelurahan, kecamatan, kota].filter(Boolean).join(', ')}</td>
                                            <td>${patient.lahir}</td>
                                            <td>${patient.email}</td>
                                            <td>${patient.telepon}</td>
                                            <td>${patient.rujukan}</td>
                                        </tr>
                                    `);
                                    
                                    // Populate services details
                                    if (services.length === 0) {
                                        serviceDetailTable.append(`
                                            <tr>
                                                <td colspan="5" class="text-center">Tidak ada data service tersedia</td>
                                            </tr>
                                        `);
                                    } else {
                                        function formatRupiah(number) {
                                            return new Intl.NumberFormat('id-ID', {
                                                style: 'currency',
                                                currency: 'IDR'
                                            }).format(number);
                                        }
                                        // Mengisi tabel dengan data service jika ada
                                        services.forEach(function(service, index) {
                                            let formattedBiaya = formatRupiah(service.harga_bayar);
                                            serviceDetailTable.append(`
                                                <tr>
                                                    <td class="align-middle text-center">${index + 1}</td>
                                                    <td class="align-middle text-center">${service.tanggal}</td>
                                                    <td class="align-middle text-center">${service.service.service}</td>
                                                    <td class="align-middle text-center">${formattedBiaya}</td>
                                                    <td class="align-middle text-center">${service.dentist.nama_dokter}</td>
                                                </tr>
                                            `);
                                        });
                                    }
                                }
                            });
                        });
                    });
                        </script>
                        
                        <!-- script modal detail pasien end -->



                        <!-- script delete pasien start -->

                        <script>
                            $(document).ready(function() {
                                $('.delete-btn').on('click', function() {
                                    // Konfirmasi sebelum menghapus
                                    if (confirm('Are you sure you want to delete this patient?')) {
                                        let patientId = $(this).data('id');
                                        
                                        $.ajax({
                                            url: '/patients-delete/' + patientId,
                                            method: 'DELETE',
                                            data: {
                                                _token: '{{ csrf_token() }}' // Pastikan untuk mengirimkan token CSRF
                                            },
                                            success: function(response) {
                                                if (response.success) {
                                                    // Hapus baris tabel atau lakukan refresh
                                                    $(`[data-id="${patientId}"]`).closest('tr').remove();
                                                    alert('Patient deleted successfully.');
                                                } else {
                                                    alert('Failed to delete patient.');
                                                }
                                            },
                                            error: function() {
                                                alert('Error occurred while deleting patient.');
                                            }
                                        });
                                    }
                                });
                            });
                        </script>

                        <!-- script delete pasien end -->






                        <!-- script saran pencarian alamat start -->

                        <script>
                            $(document).ready(function() {
                                // Event handler untuk input pada field alamat
                                $('#alamat').on('input click', function() {
                                    let query = $(this).val();

                                    // Jika panjang input lebih dari 1 karakter, lakukan AJAX request
                                    if (query.length > 1 || $(this).is(':focus')) {
                                        $.ajax({
                                            url: '{{ route("search.lokasi") }}', // URL untuk route pencarian lokasi
                                            method: 'GET', // Metode HTTP yang digunakan
                                            data: { query: query }, // Data yang dikirimkan dalam request
                                            success: function(data) {
                                                // Membangun HTML untuk saran lokasi berdasarkan data yang diterima
                                                let suggestions = data.map(function(item) {
                                                    return `<div class="alamat-suggestion-item" data-kota="${item.kecamatan.kota.nama_kota}" data-kecamatan="${item.kecamatan.nama_kecamatan}" data-kelurahan="${item.nama_kelurahan}">${item.nama_kelurahan}, ${item.kecamatan.nama_kecamatan}, ${item.kecamatan.kota.nama_kota}</div>`;
                                                }).join('');
                                                
                                                // Menampilkan saran lokasi
                                                $('#alamatSuggestions').html(suggestions).show();
                                            }
                                        });
                                    } else {
                                        // Jika input kurang dari 2 karakter, sembunyikan saran
                                        $('#alamatSuggestions').empty().hide();
                                    }
                                });

                                // Event handler untuk memilih saran lokasi
                                $(document).on('click', '.alamat-suggestion-item', function() {
                                    let nama_kota = $(this).data('kota');
                                    let nama_kecamatan = $(this).data('kecamatan');
                                    let nama_kelurahan = $(this).data('kelurahan');

                                    // Mengisi input dengan data yang dipilih dari saran
                                    $('#alamat').val(`${nama_kelurahan}, ${nama_kecamatan}, ${nama_kota}`);
                                    $('#kota').val(nama_kota);
                                    $('#kecamatan').val(nama_kecamatan);
                                    $('#kelurahan').val(nama_kelurahan);
                                    $('#alamatSuggestions').empty().hide(); // Sembunyikan saran setelah dipilih
                                });

                                // Sembunyikan saran ketika klik di luar saran
                                $(document).click(function(e) {
                                    if (!$(e.target).closest('#alamatSuggestions, #alamat').length) {
                                        $('#alamatSuggestions').empty().hide();
                                    }
                                });

                                $('#resetCustomerFormBtn').click(function() {
                                    $('#customerForm')[0].reset(); // Mengatur ulang form

                                    // Mengosongkan dan menyembunyikan saran alamat
                                    $('#alamatSuggestions').empty().hide();
                                });
                            });
                        </script>

                        <!-- script saran pencarian alamat end -->

                        




                        <!-- script untuk menambahkan service start -->

                        <script>
                        $(document).ready(function() {
                        // Tambah service baru
                        $('#service-container').on('click', '.add-service-btn', function() {
                            var newService = `
                                <div class="input-group">
                                    <input type="text" class="form-control service-name mt-4" name="service[]" placeholder="Masukkan Service" autocomplete="off" required autocomplete="off">
                                    <input type="number" class="form-control service-cost mt-4" name="tarif[]" placeholder="Tarif" required autocomplete="off">
                                    <input type="text" class="form-control service-diskon mt-4" name="diskon_klinik[]" placeholder="Diskon Klinik" autocomplete="off">
                                    <input type="text" class="form-control service-bayar mt-4" name="harga_bayar[]" placeholder="Harga Bayar" autocomplete="off">
                                    <div class="input-group-append">
                                        <button type="button" class="btn btn-danger remove-service-btn mt-4">-</button>
                                    </div>
                                </div>
                                <div class="service-suggestions"></div>`;
                            $('#service-container').append(newService);
                        });

                        // Hapus service
                        $('#service-container').on('click', '.remove-service-btn', function() {
                            $(this).closest('.input-group').remove();
                        });

                        // AJAX request untuk saran
                        $('#service-container').on('input click', '.service-name', function() {
                            let input = $(this);
                            let query = input.val();
                            let suggestionsContainer = input.closest('.input-group').next('.service-suggestions'); // Dapatkan div saran yang tepat

                            if (query.length > 1 || input.is(':focus')) {
                                $.ajax({
                                    url: '/search-service', // Ubah URL sesuai dengan route Anda
                                    method: 'GET',
                                    data: { query: query },
                                    success: function(data) {
                                        let suggestions = data.map(function(item) {
                                            return `<div class="suggestion-item-service">${item.service}</div>`;
                                        }).join('');
                                        suggestionsContainer.html(suggestions).show();
                                    },
                                    error: function(error) {
                                        console.log('Error:', error);
                                    }
                                });
                            } else {
                                suggestionsContainer.empty().hide();
                            }
                        });

                        // Pilih saran
                        $('#service-container').on('click', '.suggestion-item-service', function() {
                            let selectedService = $(this).text();
                            $(this).closest('.service-suggestions').prev('.input-group').find('.service-name').val(selectedService);
                            $(this).parent().empty().hide();
                        });

                        // Sembunyikan saran ketika klik di luar
                        $(document).click(function(e) {
                            if (!$(e.target).closest('.service-name, .service-suggestions').length) {
                                $('.service-suggestions').empty().hide();
                            }
                        });
                    });
                        </script>

                        <!-- script untuk menambahkan service end -->







                        <!-- script untuk menambah nomor rekam medis otomatis start -->


                        <script>
                        $(document).ready(function() {
                            $('#namaCustomer').on('input', function() {
                                let nama = $(this).val();

                                if (nama.length > 0) {
                                    $.ajax({
                                        url: '{{ route('generate-norm') }}',
                                        type: 'POST',
                                        data: {
                                            _token: '{{ csrf_token() }}',
                                            nama: nama
                                        },
                                        success: function(response) {
                                            $('#norm').val(response.norm);
                                        },
                                        error: function(xhr) {
                                            console.log(xhr.responseText);
                                        }
                                    });
                                } else {
                                    $('#norm').val(''); // Kosongkan input norm jika nama kosong
                                }
                            });
                        });
                    </script>


                        <!-- script untuk menambah nomor rekam medis otomatis end -->

                        @endsection
