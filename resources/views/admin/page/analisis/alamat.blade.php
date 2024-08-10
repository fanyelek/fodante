
@extends('template-dashboard')
 @section('dashboard')


                            <div class="card shadow mb-2">
                                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                                    <h6 class="m-0 font-weight-bold text-primary">Pasien Dante</h6>
                                    <div class="d-flex ml-auto">
                                        <button class="btn btn-success ml-2 mr-4" data-toggle="modal" data-target="#contohTombol" style="font-size: 14px">Contoh Tombol</button>

                                        <div class="separator"></div>

                                        <style>
                                        .separator {
                                            border-left: 1px solid #d1d1d1; /* Warna garis samar */
                                            height: 30px; /* Tinggi garis, sesuaikan dengan kebutuhan */
                                            margin: 0 10px; /* Jarak kiri dan kanan garis */
                                            margin-top: 5px;
                                            display: inline-block; /* Agar elemen tampil sejajar dengan tombol */
                                        }
                                        #addPatientModal ::placeholder {
                                            color: rgba(0, 0, 0, 0.3); /* Mengatur warna font placeholder menjadi hitam dengan opacity 40% */
                                            font-size: 14px;
                                        }

                                        .service-suggestions {
                                            border: 1px solid #ddd;
                                            border-radius: 4px;
                                            max-height: 200px;
                                            overflow-y: auto;
                                            position: absolute;
                                            z-index: 1000;
                                            background-color: #fff;
                                        }

                                        .suggestion-item-service {
                                            padding: 8px;
                                            cursor: pointer;
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
                                    


                                </div>
                            </div>

@endsection