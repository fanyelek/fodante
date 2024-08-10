
@extends('template-dashboard')
 @section('dashboard')


                    <div class="card shadow mb-2">
                                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                                    <h6 class="m-0 font-weight-bold text-primary">Pasien Dante</h6>
                                    <div class="d-flex ml-auto">
                                        <button class="btn btn-success ml-2 mr-4" data-toggle="modal" data-target="#addPatientModal" style="font-size: 14px">Tambah Pasien</button>

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

                                        /* search untuk icon search nama */
                                        .input-group .form-control::placeholder {
                                            color: #6c757d;
                                            opacity: 1; /* Firefox */
                                        }
                                        .input-group .input-group-text {
                                            color: #6c757d;
                                            background-color: transparent;
                                            border-left: none;
                                        }
                                        .input-group .form-control {
                                            border-right: none;
                                        }
                                        .input-group .form-control:focus {
                                            box-shadow: none;
                                        }
                                        .input-group .input-group-append .input-group-text {
                                            border-left: none;
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
                                                <th class="align-middle text-center">Jumlah Kunjungan</th>
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
                                            @foreach($pasien as $pasiens)
                                            <tr>
                                                <td class="align-middle text-center">{{ $loop->iteration }}</td>
                                                <td class="align-middle text-center">{{ $pasiens->norm }}</td>
                                                <td class="align-middle text-center">{{ \Carbon\Carbon::parse($pasiens->tanggal)->format('d-m-Y') }}</td>
                                                <td class="align-middle">{{ $pasiens->nama }}</td>
                                                <td class="align-middle text-center">{{ $pasiens->kunjungan }}</td>
                                                <td class="align-middle">{{ $pasiens->alamat }}</td>
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
                    
                        <!-- Star Modal -->
                        
                        <div class="modal fade" id="addPatientModal" tabindex="-1" role="dialog" aria-labelledby="addPatientModalLabel" aria-hidden="true">
                            <div class="modal-dialog custom-modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title text-primary" id="addPatientModalLabel">Tambah Perawatan/Layanan/Tindakan</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                    <form action="{{ route('store-pasien') }}" method="POST" id="patientForm">
                                            @csrf
                                            <div class="row">
                                                <div class="col-md-6" style="background: #f3f1f1; border-radius: 10px; margin-bottom: 10px;">
                                                    <div class="row">                                                        
                                                        <div class="col-md-12" style="padding-top: 5px">
                                                            <div class="form-group">
                                                                <label style="font-size: 14px; font-weight: 700; color: black" for="searchPatient">Cari Pasien Disini</label>
                                                                    <div class="input-group">   
                                                                        <input style="font-size: 14px" type="text" name="search_patient" class="form-control" id="searchPatient" placeholder="Masukkan nama yang ingin dicari" autocomplete="off" required>
                                                                        <div class="input-group-append">
                                                                            <span class="input-group-text"><i class="fas fa-search"></i></span>
                                                                        </div>
                                                                    </div>
                                                                <div style="font-size: 14px" id="namaSuggestions" class="suggestions-list"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6" style="padding-top: 5px">
                                                            <div class="form-group">
                                                                <label style="font-size: 14px; font-weight: 700; color: black" for="patientName">Nama</label>
                                                                <input style="font-size: 14px" type="text" name="nama" class="form-control" id="patientName" placeholder="Masukkan Nama" autocomplete="off" required>
                                                                <div style="font-size: 14px" id="namaSuggestions" class="suggestions-list"></div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label style="font-size: 14px; font-weight: 700; color: black" for="birhtDate">Tanggal Lahir</label>
                                                                <input style="font-size: 14px" type="date" name="lahir" class="form-control" id="birhtDate" autocomplete="off" required>
                                                            </div>
                                                            <div class="form-group">
                                                                <label style="font-size: 14px; font-weight: 700; color: black" for="email">Email</label>
                                                                <input style="font-size: 14px" type="email" name="email" class="form-control" id="email" placeholder="Masukkan Email" autocomplete="off" required>
                                                            </div>
                                                            <div class="form-group">
                                                                <label style="font-size: 14px; font-weight: 700; color: black" for="phoneNumber">No. Telepon</label>
                                                                <input style="font-size: 14px" type="number" name="telepon" class="form-control" id="phoneNumber" placeholder="Masukkan No. Telepon" autocomplete="off" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6" style="background: #ffffff; border-radius: 10px; padding-top: 5px; border-right: 2px solid #f3f1f1">
                                                            <div class="form-group">
                                                                <label style="font-size: 14px; font-weight: 700; color: black" for="address">Cari Alamat</label>
                                                                <div class="input-group">
                                                                    <input style="font-size: 14px; " type="text" name="alamat" class="form-control" id="address" placeholder="Cari alamat" autocomplete="off">
                                                                    <div class="input-group-append"> 
                                                                        <span class="input-group-text" style="background-color: #f3f1f1;"  ><i class="fas fa-search"></i></span>
                                                                    </div>
                                                                    <div style="font-size: 14px" id="alamatSuggestions" class="suggestions-list"></div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label style="font-size: 14px; font-weight: 700; color: black" for="kota">Kota</label>
                                                                <input style="font-size: 14px" type="text" name="kota" class="form-control" id="kota" placeholder="Kota" autocomplete="off" required>
                                                            </div>
                                                            <div class="form-group">
                                                                <label style="font-size: 14px; font-weight: 700; color: black" for="kecamatan">Kecamatan</label>
                                                                <input style="font-size: 14px" type="text" name="kecamatan" class="form-control" id="kecamatan" placeholder="Kota/Kecamatan" autocomplete="off" required>
                                                            </div>
                                                            <div class="form-group">
                                                                <label style="font-size: 14px; font-weight: 700; color: black" for="kelurahan">Kelurahan</label>
                                                                <input style="font-size: 14px" type="text" name="kelurahan" class="form-control" id="kelurahan" placeholder="Kota/Kecamatan" autocomplete="off" required>
                                                            </div>
                                                        </div>
                                                    </div>                                                
                                                    <div class="row"  style="margin-top: 10px" >
                                                        <div class="col-md-6">                                                            
                                                            <div class="form-group">
                                                                <label style="font-size: 14px; font-weight: 700; color: black" for="referral">Rujukan <span style="font-size: 14px; font-weight: 500; color: #b0b0b0">(optional)</span></label>
                                                                <input style="font-size: 14px" type="text" name="rujukan" class="form-control" id="referral" placeholder="Masukkan Rujukan" autocomplete="off">
                                                            </div>
                                                        </div>                                                    
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label style="font-size: 14px; font-weight: 700; color: black" for="adminNote">Catatan Admin <span style="font-size: 14px; font-weight: 500; color: #b0b0b0">(optional)</span></label required>
                                                                <input style="font-size: 14px" type="text" name="adminNote" class="form-control" id="adminNote" placeholder="Catatan admin" autocomplete="off">
                                                            </div>
                                                        </div>                                                    
                                                    </div>                                                                                                        
                                                </div>
                                                <div class="col-md-6" style="padding-top: 5px">
                                                    <div class="row">
                                                        <div class="col-md-6" >
                                                            <div class="form-group">
                                                                <label style="font-size: 14px; font-weight: 700; color: black" for="dokter">Dokter</label>
                                                                <input style="font-size: 14px" type="text" name="dokter" class="form-control" id="dokter" placeholder="Masukkan Dokter" autocomplete="off" required>
                                                                <div id="doctorSuggestions" class="suggestions-list"></div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label style="font-size: 14px; font-weight: 700; color: black" for="visitDate">Tanggal Kunjungan</label>
                                                                <input style="font-size: 14px" type="date" name="tanggal" class="form-control" id="visitDate" autocomplete="off" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- <div class="form-group">
                                                        <label style="font-size: 14px; font-weight: 700; color: black" for="adminNote">Catatan Pasien</label>
                                                        <textarea style="font-size: 14px" class="form-control" name="adminNote" id="adminNote" rows="4" placeholder="Masukkan Catatan Admin" autocomplete="off"></textarea>
                                                    </div> -->
                                                    <div class="form-group">
                                                        <label style="font-size: 14px; font-weight: 700; color: black" for="service">Service</label>
                                                        <div id="service-container">
                                                            <div class="input-group">
                                                                <input style="font-size: 14px" type="text" class="form-control service-name" name="service[]" placeholder="Masukkan Service" autocomplete="off" required>
                                                                <input style="font-size: 14px" type="number" class="form-control service-cost" name="biaya[]" placeholder="Masukkan Biaya" autocomplete="off" required>
                                                                <input style="font-size: 14px" type="text" class="form-control service-note" name="catatan[]" placeholder="Masukkan Catatan Admin" autocomplete="off"></textarea>
                                                                <div class="input-group-append">
                                                                    <button type="button" class="btn btn-primary add-service-btn" style="font-size: 14px">+</button>
                                                                </div>
                                                            </div>
                                                            <div class="service-suggestions"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" style="font-size: 14px" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                <button type="button" style="font-size: 14px" class="btn btn-warning" id="resetFormBtn">Reset Form</button>
                                                <button type="submit" style="font-size: 14px" class="btn btn-primary">Save changes</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        
                        <!-- <div class="modal fade" id="addPatientModal" tabindex="-1" role="dialog" aria-labelledby="addPatientModalLabel" aria-hidden="true">
                            <div class="modal-dialog custom-modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="addPatientModalLabel">Form Input Pasien</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                    <form action="{{ route('store-pasien') }}" method="POST" id="patientForm">
                                            @csrf
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label style="font-size: 14px; font-weight: 700; color: black" for="patientName">Nama</label>
                                                        <input style="font-size: 14px" type="text" name="nama" class="form-control" id="patientName" placeholder="Masukkan Nama" autocomplete="off" required>
                                                        <div style="font-size: 14px" id="namaSuggestions" class="suggestions-list"></div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label style="font-size: 14px; font-weight: 700; color: black" for="birhtDate">Tanggal Lahir</label>
                                                        <input style="font-size: 14px" type="date" name="lahir" class="form-control" id="birhtDate" autocomplete="off" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label style="font-size: 14px; font-weight: 700; color: black" for="address">Alamat</label>
                                                        <input style="font-size: 14px" type="text" name="alamat" class="form-control" id="address" placeholder="Kota/Kecamatan" autocomplete="off" required>
                                                        <div style="font-size: 14px" id="alamatSuggestions" class="suggestions-list"></div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label style="font-size: 14px; font-weight: 700; color: black" for="email">Email</label>
                                                        <input style="font-size: 14px" type="email" name="email" class="form-control" id="email" placeholder="Masukkan Email" autocomplete="off" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label style="font-size: 14px; font-weight: 700; color: black" for="phoneNumber">No. Telepon</label required>
                                                        <input style="font-size: 14px" type="tel" name="telepon" class="form-control" id="phoneNumber" placeholder="Masukkan No. Telepon" autocomplete="off">
                                                    </div>
                                                    <div class="form-group">
                                                        <label style="font-size: 14px; font-weight: 700; color: black" for="visitDate">Tanggal Kunjungan</label>
                                                        <input style="font-size: 14px" type="date" name="tanggal" class="form-control" id="visitDate" autocomplete="off" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label style="font-size: 14px; font-weight: 700; color: black" for="dokter">Dokter</label>
                                                        <input style="font-size: 14px" type="text" name="dokter" class="form-control" id="dokter" placeholder="Masukkan Dokter" autocomplete="off" required>
                                                        <div id="doctorSuggestions" class="suggestions-list"></div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label style="font-size: 14px; font-weight: 700; color: black" for="referral">Rujukan</label>
                                                        <input style="font-size: 14px" type="text" name="rujukan" class="form-control" id="referral" placeholder="Masukkan Rujukan" autocomplete="off">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label style="font-size: 14px; font-weight: 700; color: black" for="adminNote">Catatan Pasien</label>
                                                        <textarea style="font-size: 14px" class="form-control" name="adminNote" id="adminNote" rows="4" placeholder="Masukkan Catatan Admin" autocomplete="off"></textarea>
                                                    </div>
                                                    <div class="form-group">
                                                        <label style="font-size: 14px; font-weight: 700; color: black" for="service">Service</label>
                                                        <div id="service-container">
                                                            <div class="input-group">
                                                                <input style="font-size: 14px" type="text" class="form-control service-name" name="service[]" placeholder="Masukkan Service" autocomplete="off" required>
                                                                <input style="font-size: 14px" type="number" class="form-control service-cost" name="biaya[]" placeholder="Masukkan Biaya" autocomplete="off" required>
                                                                <input style="font-size: 14px" type="text" class="form-control service-note" name="catatan[]" placeholder="Masukkan Catatan Admin" autocomplete="off"></textarea>
                                                                <div class="input-group-append">
                                                                    <button type="button" class="btn btn-primary add-service-btn" style="font-size: 14px">+</button>
                                                                </div>
                                                            </div>
                                                            <div class="service-suggestions"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" style="font-size: 14px" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                <button type="button" style="font-size: 14px" class="btn btn-warning" id="resetFormBtn">Reset Form</button>
                                                <button type="submit" style="font-size: 14px" class="btn btn-primary">Save changes</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div> -->

                        <!-- End of Modal -->

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
                                    <form action="{{ route('import-data-kunjungan') }}" method="POST" enctype="multipart/form-data">
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
                                                            <th class="align-middle text-center">Dokter</th>
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
                                max-width: 90%; /* Set to the percentage or pixel width you want */
                            }

                            .custom-modal-sedang {
                                max-width: 50%; /* Set to the percentage or pixel width you want */
                            }

                        </style>

                         <!-- End Modal Detail  -->

                         <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                         <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
                        


                         <!-- script modal tambah pasien start -->
                         
                         <script>
                            $(document).ready(function() {
                            // Fungsi untuk menampilkan saran pencarian nama pasien
                            $('#searchPatient').on('input', function() {
                                let query = $(this).val();

                                if (query.length > 1) {
                                    $.ajax({
                                        url: '/search-nama',
                                        method: 'GET',
                                        data: { query: query },
                                        success: function(data) {
                                            console.log(data);
                                            let suggestions = data.map(function(item) {
                                                
                                            // console.log(item.nama);
                                                return `<div class="suggestion-item" 
                                                data-adminnote="${item.adminNote}" 
                                                data-nama="${item.nama}" 
                                                data-id="${item.id}" 
                                                data-tanggal="${item.tanggal}" 
                                                data-lahir="${item.lahir}" 
                                                data-email="${item.email}" 
                                                data-service="${item.service}" 
                                                data-norm="${item.norm}" 
                                                data-kota="${item.kota}" 
                                                data-kecamatan="${item.kecamatan}" 
                                                data-kelurahan="${item.kelurahan}" 
                                                data-service="${item.service}" 
                                                data-biaya="${item.biaya}" 
                                                data-telepon="${item.telepon}" 
                                                data-rujukan="${item.rujukan}">${item.nama}</div>`;
                                            }).join('');
                                            $('#namaSuggestions').html(suggestions).show();
                                        }
                                    });
                                } else {
                                    $('#namaSuggestions').empty().hide();
                                }
                            });

                                $(document).on('click', '.suggestion-item', function() {
                                    let selectedName = $(this).data('nama');
                                    let birhtDate = $(this).data('lahir');
                                    let kota = $(this).data('kota');
                                    let kecamatan = $(this).data('kecamatan');
                                    let kelurahan = $(this).data('kelurahan');
                                    let service = $(this).data('service');
                                    let norm1 = $(this).data('norm');
                                    let visitDate = $(this).data('tanggal');
                                    let telepon = $(this).data('telepon');
                                    let adminNote = $(this).data('adminnote');
                                    let referral = $(this).data('rujukan');
                                    let email = $(this).data('email');
                                    let cost = $(this).data('biaya');

                                    // $('#medicalRecordNumber').val(norm1);
                                    $('#visitDate').val(visitDate);
                                    $('#phoneNumber').val(telepon).attr('readonly', true);
                                    $('#kota').val(kota).attr('readonly', true);
                                    $('#kecamatan').val(kecamatan).attr('readonly', true);
                                    $('#kelurahan').val(kelurahan).attr('readonly', true);
                                    $('#email').val(email).attr('readonly', true);
                                    $('#referral').val(referral);
                                    $('#patientName').val(selectedName).attr('readonly', true);
                                    $('#birhtDate').val(birhtDate).attr('readonly', true);
                                    $('#address').val(alamat).attr('readonly', true);
                                    // $('#service').val(service);
                                    $('#cost').val(cost);
                                    $('#adminNote').val(adminNote);
                                    $('#namaSuggestions').empty().hide();
                                });

                                $(document).click(function(e) {
                                    if (!$(e.target).closest('#namaSuggestions, #patientName').length) {
                                        $('#namaSuggestions').empty().hide();
                                    }
                                });

                                $('#resetFormBtn').click(function() {
                                    $('input, textarea').removeAttr('readonly');
                                    $('#patientForm')[0].reset();
                                });
                            });
                            </script>
                         
                         <!-- script modal tambah pasien end -->




                         <!-- script modal detail pasien start -->

                        <script>
                        $(document).ready(function() {
                            $('.detail-btn').on('click', function() {
                                let patientId = $(this).data('id');

                                $.ajax({
                                    url: '/get-patient-details/' + patientId,
                                    method: 'GET',
                                    success: function(response) {
                                        let patient = response.pasien;
                                        let services = response.services;
                                        
                                        let patientDetailTable = $('#patientDetailTable tbody');
                                        let serviceDetailTable = $('#serviceDetailTable tbody');
                                        
                                        // Clear previous data
                                        patientDetailTable.empty();
                                        serviceDetailTable.empty();
                                        
                                        // Populate patient details
                                        patientDetailTable.append(`
                                            <tr>
                                                <td class="align-middle text-center">${patient.id}</td>
                                                <td class="align-middle text-center">${patient.norm}</td>
                                                <td>${patient.nama}</td>
                                                <td class="align-middle text-center">${patient.age}</td>
                                                <td class="align-middle text-center">${patient.kelurahan}, ${patient.kecamatan}, ${patient.kota}</td>
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
                                                let formattedBiaya = formatRupiah(service.biaya);
                                                serviceDetailTable.append(`
                                                    <tr>
                                                        <td class="align-middle text-center">${index + 1}</td>
                                                        <td class="align-middle text-center">${service.tanggal}</td>
                                                        <td class="align-middle text-center">${service.service}</td>
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
                        $('#address').on('input', function() {
                            let query = $(this).val();

                            // Jika panjang input lebih dari 1 karakter, lakukan AJAX request
                            if (query.length > 1) {
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
                            $('#address').val(`${nama_kelurahan}, ${nama_kecamatan}, ${nama_kota}`);
                            $('#kota').val(nama_kota);
                            $('#kecamatan').val(nama_kecamatan);
                            $('#kelurahan').val(nama_kelurahan);
                            $('#alamatSuggestions').empty().hide(); // Sembunyikan saran setelah dipilih
                        });

                        // Sembunyikan saran ketika klik di luar saran
                        $(document).click(function(e) {
                            if (!$(e.target).closest('#alamatSuggestions, #address').length) {
                                $('#alamatSuggestions').empty().hide();
                            }
                        });
                    });
                        </script>

                        <!-- script saran pencarian alamat end -->

                        

                        <!-- script isi field dokter start -->

                        <script>
                            $('#dokter').on('input', function() {
                            let query = $(this).val();

                            // Jika panjang input lebih dari 2 karakter, lakukan AJAX request
                            if (query.length > 1) {
                                $.ajax({
                                    url: '{{ route("search-dentist") }}', // URL untuk route pencarian dokter
                                    method: 'GET', // Metode HTTP yang digunakan
                                    data: { query: query }, // Data yang dikirimkan dalam request
                                    success: function(data) {
                                        // Membangun HTML untuk saran dokter berdasarkan data yang diterima
                                        let suggestions = data.map(function(item) {
                                            return `<div class="doctor-suggestion-item" data-dokter="${item.nama_dokter}">${item.nama_dokter}</div>`;
                                        }).join('');
                                        
                                        // Menampilkan saran dokter
                                        $('#doctorSuggestions').html(suggestions).show();
                                    }
                                });
                            } else {
                                // Jika input kurang dari 3 karakter, sembunyikan saran
                                $('#doctorSuggestions').empty().hide();
                            }
                        });

                            // Mengisi input dengan pilihan dari suggestions list
                            $(document).on('click', '.doctor-suggestion-item', function() {
                            let nama_dokter = $(this).data('dokter');

                            // Mengisi input dokter dengan data yang dipilih dari saran
                            $('#dokter').val(nama_dokter);
                            $('#doctorSuggestions').empty().hide(); // Sembunyikan saran setelah dipilih
                        });
                        </script>

                        <!-- script isi field dokter end -->






                        <!-- script untuk menambahkan service start -->

                        <script>
                            $(document).ready(function() {
                            // Tambah service baru
                            $('#service-container').on('click', '.add-service-btn', function() {
                                var newService = `
                                    <div class="input-group">
                                        <input type="text" style="font-size: 14px" class="form-control service-name  mt-2" name="service[]" placeholder="Masukkan Service" autocomplete="off">
                                        <input type="number" style="font-size: 14px" class="form-control service-cost  mt-2" name="biaya[]" placeholder="Masukkan Biaya" autocomplete="off">
                                        <input type="text" style="font-size: 14px" class="form-control service-note  mt-2" name="catatan[]" placeholder="Masukkan Catatan Admin" autocomplete="off"></textarea>
                                        <div class="input-group-append">
                                            <button type="button" class="btn btn-danger remove-service-btn  mt-2" style="font-size: 14px">-</button>
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
                            $('#service-container').on('input', '.service-name', function() {
                                let input = $(this);
                                let query = input.val();
                                let suggestionsContainer = input.closest('.input-group').next('.service-suggestions'); // Dapatkan div saran yang tepat

                                if (query.length > 1) {
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
                                if (!$(e.target).closest('.service-name').length) {
                                    $('.suggestion-item-service').empty().hide();
                                }
                            });
                        });
                        </script>

                        <!-- script untuk menambahkan service end -->


                        @endsection
