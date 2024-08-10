
@extends('template-dashboard')
 @section('data-dokter')


                    <div class="card shadow mb-4">
                        <div class="card-header py-3 d-flex justify-content-between align-items-center">
                                    <h6 class="m-0 font-weight-bold text-primary">Data Dentis Dante</h6>
                                    <div class="d-flex ml-auto">
                                        <button style="font-size: 14px" class="btn btn-success ml-2 mr-4" data-toggle="modal" data-target="#addDentistModal">Tambah Dentis</button>

                                        <div class="separator"></div>

                                        <style>
                                        .separator {
                                            border-left: 1px solid #d1d1d1; /* Warna garis samar */
                                            height: 30px; /* Tinggi garis, sesuaikan dengan kebutuhan */
                                            margin: 0 10px; /* Jarak kiri dan kanan garis */
                                            margin-top: 5px;
                                            display: inline-block; /* Agar elemen tampil sejajar dengan tombol */
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
                                            <a class="dropdown-item" data-toggle="modal" data-target="#exportModal">Export Data Dentis</a>
                                            <a class="dropdown-item" data-toggle="modal" data-target="#importModal">Import Data Dentis</a>
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
                                                <th class="align-middle text-center">Nama Dentis</th>
                                                <th class="align-middle text-center">Action</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th class="align-middle text-center">No.</th>
                                                <th class="align-middle text-center">Nama Dentis</th>
                                                <th class="align-middle text-center">Action</th>
                                            </tr>
                                        </tfoot>
                                        <tbody>
                                            @foreach($dentist as $data_dentist)
                                            <tr>
                                                <td class="align-middle text-center" style="width: 10%">{{ $loop->iteration }}</td>
                                                <td class="align-middle">{{ $data_dentist->nama_dokter }}</td>
                                                <td class="align-middle" style="width: 10%" >
                                                <div class="d-flex ml-auto">
                                                    <!-- <button class="btn btn-success ml-2 " data-toggle="modal" data-target="#dentisedit">Edit</button> -->
                                                    <button style="font-size: 12px" class="btn btn-success ml-2 edit-btn" data-toggle="modal" data-target="#dentistEditModal" data-id="{{ $data_dentist->id }}">Edit</button>
                                                    <button style="font-size: 12px" class="btn btn-danger ml-2 delete-btn" data-toggle="modal" data-id="{{ $data_dentist->id }}">Delete</button>
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
                        
                        <div class="modal fade" id="addDentistModal" tabindex="-1" role="dialog" aria-labelledby="addDentistModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="card shadow mb-4"> 
                                    <div class="modal-content">
                                        <div class="modal-header card-header py-3">
                                            <h5 class="modal-title" id="addDentistModalLabel">Tambah Dentist</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="card-body">
                                            <div class="modal-body">
                                                <form action="{{ route('store.dentist') }}" method="POST" id="dentistForm">
                                                    @csrf
                                                    <div class="form-group">
                                                        <label for="patientName">Nama</label>
                                                        <input type="text" name="nama_dokter" class="form-control" id="dentisttName" placeholder="Masukkan Nama" autocomplete="off">
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button style="font-size: 12px" type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                        <button style="font-size: 12px" type="button" class="btn btn-warning" id="resetFormBtn">Reset Form</button>
                                                        <button style="font-size: 12px" type="submit" class="btn btn-primary">Save changes</button>
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
                                        <h5 class="modal-title" id="importModalLabel">Import Data Dentis</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form action="{{ route('import-dentis') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label for="importFile">Pilih file untuk diimport</label>
                                                <input type="file" class="form-control-file" id="importFile" name="file_data_dentis" required>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal" >Close</button>
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
                                        <h5 class="modal-title" id="exportModallLabel">Export Data Dentist</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                        <div class="modal-body">
                                                <label>Anda yakin untuk mengeksport Data Dentist?</label>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            <a href="{{ route('export.dentist') }}"><button type="button" class="btn btn-primary">Export</button></a>
                                        </div>
                                </div>
                            </div>
                        </div>

                         <!-- End Modal Import -->

                         <!-- Modal Edit Dentis Start -->

                         <div class="modal fade" id="dentistEditModal" tabindex="-1" role="dialog" aria-labelledby="dentistEditModalLabel" aria-hidden="true">
                            <div class="modal-dialog custom-modal-sedang" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="dentistEditModalLabel">Edit Detail Dentist</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <!-- Card for Dentist Details -->
                                        <div class="card mb-4">
                                            <div class="card-header">
                                                <h6 class="m-0 font-weight-bold text-primary">Data Pasien</h6>
                                            </div>
                                            <div class="card-body">
                                                <table class="table table-bordered" id="dentistDetailTable" width="100%" cellspacing="0" style="font-size: 12px">
                                                    <thead>
                                                        <tr>
                                                            <th class="align-middle text-center">No.</th>
                                                            <th class="align-middle text-center">Nama Dentist</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <form id="editDentistForm" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                        <input type="hidden" name="id" id="dentistId" value="">
                                                            <div class="form-group">
                                                                <label style="font-size: 15px; color: black; font-weight: 700" for="dentistName">Nama</label>
                                                                <input type="text" name="dentistName" class="form-control" id="dentistName" placeholder="Masukkan Nama" autocomplete="off">
                                                                <div id="namaSuggestions" class="suggestions-list"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button style="font-size: 13px" type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                        <button style="font-size: 13px" type="button" class="btn btn-warning" id="resetFormBtn">Reset Form</button>
                                                        <button style="font-size: 13px" type="submit" class="btn btn-primary">Save changes</button>
                                                    </div>
                                                </form>
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
                         <!-- Modal Edit Dentis End -->

                         <!-- script edit detail dentist start -->
                         <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

                            <script>
                                $(document).ready(function() {
                                    $('.edit-btn').on('click', function() {
                                        let dentistId = $(this).data('id');

                                        $.ajax({
                                            url: '/get-dentist/' + dentistId,
                                            method: 'GET',
                                            success: function(response) {
                                                let dentist_id = response.id;
                                                let dentist_nama = response.nama_dokter;

                                                $('#dentistId').val(response.id);
                                                $('#dentistName').val(response.nama_dokter);

                                                let dentistDetailTable = $('#dentistDetailTable tbody');

                                                dentistDetailTable.empty();

                                                dentistDetailTable.append(`
                                            <tr>
                                                <td class="align-middle text-center">${dentist_id}</td>
                                                <td class="align-middle text-center">${dentist_nama}</td>
                                            </tr>
                                        `);



                                                // Set form action dynamically
                                                let formAction = '/update-dentist/' + response.id;
                                                $('#editDentistForm').attr('action', formAction);
                                            },
                                            error: function(error) {
                                                console.log('Error:', error);
                                            }
                                        });
                                    });
                                });
                            </script>

                         <!-- script edit detail dentist end -->

                         <!-- script delete dokter start -->

                        <script>
                            $(document).ready(function() {
                                $('.delete-btn').on('click', function() {
                                    // Konfirmasi sebelum menghapus
                                    if (confirm('Are you sure you want to delete this dentist?')) {
                                        let dentistId = $(this).data('id');
                                        
                                        $.ajax({
                                            url: '/data-dentist-delete/' + dentistId,
                                            method: 'DELETE',
                                            data: {
                                                _token: '{{ csrf_token() }}' // Pastikan untuk mengirimkan token CSRF
                                            },
                                            success: function(response) {
                                                if (response.success) {
                                                    // Hapus baris tabel atau lakukan refresh
                                                    $(`[data-id="${dentistId}"]`).closest('tr').remove();
                                                    alert('Dentist deleted successfully.');
                                                } else {
                                                    alert('Failed to delete dentist.');
                                                }
                                            },
                                            error: function() {
                                                alert('Error occurred while deleting dentist.');
                                            }
                                        });
                                    }
                                });
                            });
                        </script>

                         <!-- script delete dokter end -->
@endsection