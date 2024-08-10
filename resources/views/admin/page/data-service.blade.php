
@extends('template-dashboard')
 @section('data-service')


                    <div class="card shadow mb-4">
                                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                                    <h6 class="m-0 font-weight-bold text-primary">Data Service Dante</h6>
                                    <div class="d-flex ml-auto">
                                        <button class="btn btn-success ml-2 mr-4" data-toggle="modal" data-target="#addServiceModal" style="font-size: 14px">Tambah Service</button>

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
                                            <a class="dropdown-item" data-toggle="modal" data-target="#exportModal">Export Data Service</a>
                                            <a class="dropdown-item" data-toggle="modal" data-target="#importModalService">Import Data Service</a>
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
                                                <th class="align-middle text-center" width="10%">No.</th>
                                                <th class="align-middle text-center">Service</th>
                                                <th class="align-middle text-center" width="10%">Action</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th class="align-middle text-center">No.</th>
                                                <th class="align-middle text-center">Service</th>
                                                <th class="align-middle text-center">Action</th>
                                            </tr>
                                        </tfoot>
                                        <tbody>
                                            @foreach($service as $data_service)
                                                <tr>
                                                    <td class="align-middle text-center" style="width: 10%">{{ $loop->iteration }}</td>
                                                    <td class="align-middle">{{ $data_service->service }}</td>
                                                    <td class="align-middle" style="width: 10%" >
                                                    <div class="d-flex ml-auto">
                                                        <!-- <button class="btn btn-success ml-2 " data-toggle="modal" data-target="#dentisedit">Edit</button> -->
                                                        <button class="btn btn-success ml-2 edit-btn" data-toggle="modal" data-target="#serviceEditModal" data-id="{{ $data_service->id }}">Edit</button>
                                                        <button style="font-size: 12px" class="btn btn-danger ml-2 delete-btn" data-toggle="modal" data-id="{{ $data_service->id }}">Delete</button>
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
                        
                        <div class="modal fade" id="addServiceModal" tabindex="-1" role="dialog" aria-labelledby="addServiceModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="card shadow mb-4"> 
                                    <div class="modal-content">
                                        <div class="modal-header card-header py-3">
                                            <h5 class="modal-title" id="addServiceModalLabel">Tambah Service</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="card-body">
                                            <div class="modal-body">
                                                <form action="{{ route('store.service') }}" method="POST" id="serviceForm">
                                                    @csrf
                                                    <div class="form-group">
                                                        <label for="serviceName">Nama</label>
                                                        <input type="text" name="service" class="form-control" id="service" placeholder="Masukkan Sevice" autocomplete="off">
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

                        <div class="modal fade" id="importModalService" tabindex="-1" role="dialog" aria-labelledby="importModalServiceLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="importModalServiceLabel">Import Data Service</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form action="{{ route('import.service') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label for="importFile">Pilih file untuk diimport</label>
                                                <input type="file" class="form-control-file" id="importService" name="importService" required>
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

                         <!-- End Modal Service -->

                         <div class="modal fade" id="serviceEditModal" tabindex="-1" role="dialog" aria-labelledby="serviceEditModalLabel" aria-hidden="true">
                            <div class="modal-dialog custom-modal-sedang" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="serviceEditModalLabel">Edit Detail Service</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <!-- Card for Service Details -->
                                        <div class="card mb-4">
                                            <div class="card-header">
                                                <h6 class="m-0 font-weight-bold text-primary">Data Service</h6>
                                            </div>
                                            <div class="card-body">
                                                <table class="table table-bordered" id="serviceDetailTable" width="100%" cellspacing="0" style="font-size: 12px">
                                                    <thead>
                                                        <tr>
                                                            <th class="align-middle text-center" width="10%">No.</th>
                                                            <th class="align-middle text-center">Service</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <form id="editServiceForm" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                        <input type="hidden" name="id" id="serviceId" value="">
                                                            <div class="form-group">
                                                                <label for="serviceName">Nama</label>
                                                                <input type="text" name="service" class="form-control" id="serviceName" placeholder="Masukkan Nama" autocomplete="off">
                                                                <div id="namaSuggestions" class="suggestions-list"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                        <button type="button" class="btn btn-warning" id="resetFormBtn">Reset Form</button>
                                                        <button type="submit" class="btn btn-primary">Save changes</button>
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
                         <!-- Modal Edit Sercice End -->


                         <!-- script edit detail service start -->

                        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

                        <script>
                            $(document).ready(function() {
                                $('.edit-btn').on('click', function() {
                                    let serviceId = $(this).data('id');

                                    $.ajax({
                                        url: '/get-service/' + serviceId,
                                        method: 'GET',
                                        success: function(response) {
                                            let service_id = response.id;
                                            let service_name = response.service;

                                            $('#serviceId').val(response.id);
                                            $('#serviceName').val(response.service);

                                            let serviceDetailTable = $('#serviceDetailTable tbody');

                                            serviceDetailTable.empty();

                                            serviceDetailTable.append(`
                                        <tr>
                                            <td class="align-middle text-center">${service_id}</td>
                                            <td class="align-middle text-center">${service_name}</td>
                                        </tr>
                                    `);



                                            // Set form action dynamically
                                            let formAction = '/update-service/' + response.id;
                                            $('#editServiceForm').attr('action', formAction);
                                        },
                                        error: function(error) {
                                            console.log('Error:', error);
                                        }
                                    });
                                });
                            });
                        </script>

                         <!-- script edit detail service end -->

                         <!-- script delete service start -->

                        <script>
                            $(document).ready(function() {
                                $('.delete-btn').on('click', function() {
                                    // Konfirmasi sebelum menghapus
                                    if (confirm('Are you sure you want to delete this Service?')) {
                                        let serviceId = $(this).data('id');
                                        
                                        $.ajax({
                                            url: '/service-delete/' + serviceId,
                                            method: 'DELETE',
                                            data: {
                                                _token: '{{ csrf_token() }}' // Pastikan untuk mengirimkan token CSRF
                                            },
                                            success: function(response) {
                                                if (response.success) {
                                                    // Hapus baris tabel atau lakukan refresh
                                                    $(`[data-id="${serviceId}"]`).closest('tr').remove();
                                                    alert('Service deleted successfully.');
                                                } else {
                                                    alert('Failed to delete Service.');
                                                }
                                            },
                                            error: function() {
                                                alert('Error occurred while deleting Service.');
                                            }
                                        });
                                    }
                                });
                            });
                        </script>

                        <!-- script delete service end -->
@endsection