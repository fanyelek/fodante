
@extends('template-dashboard')

@section('data-kota')

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">Data Kota | Kecamatan | Kelurahan </h6>
                <div class="d-flex ml-auto">
                <button class="btn btn-success ml-2" data-toggle="modal" data-target="#importModal" style="font-size: 14px">Import</button>
                </div>
        </div>
        <div class="card-body">
            <div class="card shadow mb-4">

                <!-- Tabel Kota -->

                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                        <h6 class="m-0 font-weight-bold text-primary">Kota</h6>
                </div>
                <div class="card-body">
                        <div class="table-responsive">
                                    <table class="table table-bordered" id="dataTable1" width="100%" cellspacing="0" style="font-size: 12px">
                                        <thead>
                                            <tr>
                                                <th class="align-middle text-center">id</th>
                                                <th class="align-middle text-center">Kota</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($data_kota as $kota)
                                            <tr>
                                                <td class="align-middle text-center">{{ $kota->id }}</td>
                                                <td class="align-middle text-center">{{ $kota->nama_kota }}</td>
                                            </tr>   
                                            @endforeach                                         
                                        </tbody>
                                    </table>
                                </div>
                </div>
            </div>

                <!-- Tabel Kecamatan -->

            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                        <h6 class="m-0 font-weight-bold text-primary">Kecamatan</h6>
                </div>
                <div class="card-body">
                        <div class="table-responsive">
                                    <table class="table table-bordered" id="dataTable2" width="100%" cellspacing="0" style="font-size: 12px">
                                        <thead>
                                            <tr>
                                                <th class="align-middle text-center">id</th>
                                                <th class="align-middle text-center">Kecamatan</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($data_kecamatan as $kecamatan)
                                            <tr>
                                                <td class="align-middle text-center">{{ $kecamatan->id }}</td>
                                                <td class="align-middle text-center">{{ $kecamatan->nama_kecamatan }}</td>
                                            </tr>                              
                                            @endforeach              
                                        </tbody>
                                    </table>
                                </div>
                </div>
            </div>

                <!-- Tabel Kelurahan -->

            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                        <h6 class="m-0 font-weight-bold text-primary">Kelurahan</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0" style="font-size: 12px">
                            <thead>
                                <tr>
                                    <th class="align-middle text-center">id</th>
                                    <th class="align-middle text-center">Kelurahan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($data_kelurahan as $kelurahan)
                                <tr>
                                    <td class="align-middle text-center">{{ $kelurahan->id }}</td>
                                    <td class="align-middle text-center">{{ $kelurahan->nama_kelurahan }}</td>
                                </tr>  
                                @endforeach                                          
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="importModal" tabindex="-1" role="dialog" aria-labelledby="importModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="importModalLabel">Import Data Pasien</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form action="{{ route('import-data-kota') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label for="importFileKota">Import Data Kota disini</label>
                                                <input type="file" name="kota_file" id="importFileKota">
                                                <label class=" mt-4" for="importFileKecamatan" id="importFileKecamatan">Import Data Kecamatan disini</label>
                                                <input type="file" name="kecamatan_file">
                                                <label class=" mt-4"    for="importFileKelurahan" >Import Data Kelurahan disini</label>
                                                <input type="file" name="kelurahan_file" id="importFileKelurahan">
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

@endsection