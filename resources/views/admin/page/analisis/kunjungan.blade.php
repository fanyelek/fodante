
@extends('template-dashboard')
 @section('dashboard')


                    <div class="card shadow mb-4">
                                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                                    <h6 class="m-0 font-weight-bold text-primary">Pasien Dante</h6>
                                    <div class="d-flex ml-auto">
                                    <button class="btn btn-success ml-2" data-toggle="modal" data-target="#addPatientModal">Tambah Pasien</button>
                                    <button class="btn btn-success ml-2" data-toggle="modal" data-target="#exportModal">Export</button>
                                    <button class="btn btn-success ml-2" data-toggle="modal" data-target="#importModal">Import</button>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0" style="font-size: 12px">
                                        <thead>
                                            <tr>
                                                <th class="align-middle text-center">No.</th>
                                                <th class="align-middle text-center">No. Rekam Medis</th>
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
                                                <th class="align-middle text-center">Nama</th>
                                                <th class="align-middle text-center">Jumlah Kunjungan</th>
                                                <th class="align-middle text-center">Alamat</th>
                                                <th class="align-middle text-center">Action</th>
                                            </tr>
                                        </tfoot>
                                        <tbody>
                                            <tr>
                                                <td class="align-middle text-center"></td>
                                                <td class="align-middle"></td>
                                                <td class="align-middle"></td>
                                                <td class="align-middle"></td>
                                                <td class="align-middle"></td>
                                                <td class="align-middle">
                                                <div class="d-flex ml-auto">
                                                    <button class="btn btn-success ml-2" data-toggle="modal" data-target="#addPatientModal">Tambah Pasien</button>
                                                    <button class="btn btn-success ml-2" data-toggle="modal" data-target="#exportModal">Export</button>
                                                    <button class="btn btn-success ml-2" data-toggle="modal" data-target="#importModal">Import</button>
                                                </div>
                                                </td>
                                            </tr>    
                                        </tbody>
                                    </table>
                                </div>
                                </div>
                            </div>
                    
                        <!-- Star Modal -->
                        
                        <div class="modal fade" id="addPatientModal" tabindex="-1" role="dialog" aria-labelledby="addPatientModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="card shadow mb-4"> 
                                    <div class="modal-content">
                                        <div class="modal-header card-header py-3">
                                            <h5 class="modal-title" id="addPatientModalLabel">Tambah Pasien</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="card-body">
                                            <div class="modal-body">
                                                <form action="{{ route('store-pasien') }}" method="POST" id="patientForm">
                                                    @csrf
                                                    <div class="row">
                                                        <div class="col-md-o6 mr-1">
                                                            <div class="form-group">
                                                                <label for="patientName">Nama</label>
                                                                <input type="text" name="nama" class="form-control" id="patientName" placeholder="Masukkan Nama" autocomplete="off">
                                                                <div id="namaSuggestions" class="suggestions-list"></div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="visitDate">Tanggal Kunjungan</label>
                                                                <input type="date" name="tanggal" class="form-control" id="visitDate">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="phoneNumber">No. Telepon</label>
                                                                <input type="tel" name="telepon" class="form-control" id="phoneNumber" placeholder="Masukkan No. Telepon">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="medicalRecordNumber">No. Rekam Medis</label>
                                                                <input type="text" name="norm" class="form-control" id="medicalRecordNumber" placeholder="Masukkan No. Rekam Medis">
                                                            </div>
                                                                <div class="form-group">
                                                                <label for="address">Alamat</label>
                                                                <input type="text" name="alamat" class="form-control" id="address" placeholder="Kota/Kecamatan">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-o6 ml-1">
                                                            <div class="form-group">
                                                                <label for="birhtDate">Tanggal Lahir</label>
                                                                <input type="date" name="lahir" class="form-control" id="birhtDate">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="email">Email</label>
                                                                <input type="email" name="email" class="form-control" id="email" placeholder="Masukkan Email">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="service">Service</label>
                                                                <input type="text" name="service" class="form-control" id="service" placeholder="Masukkan Service">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="cost">Biaya</label>
                                                                <input type="number" name="biaya" class="form-control" id="cost" placeholder="Masukkan Biaya">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="referral">Rujukan</label>
                                                                <input type="text" name="rujukan" class="form-control" id="referral" placeholder="Masukkan Rujukan">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="adminNote">Catatan Admin</label>
                                                        <textarea class="form-control" name="catatan" id="adminNote" rows="3" placeholder="Masukkan Catatan Admin"></textarea>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                        <button type="button" class="btn btn-warning" id="resetFormBtn">Reset Form</button>
                                                        <button type="submit" class="btn btn-primary">Save changes</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

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
@endsection