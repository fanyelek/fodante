
@extends('template-dashboard')
 @section('dashboard')


    <style>
        .chart-container {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 100%;
            height: 400px; /* Adjust this as necessary */
        }
        .chart {
            flex: 1;
            margin: 10px;
        }
        .flex-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .chart-half {
            width: 50%;
        }
        .table-responsive {
            width: 50%;
            margin-top: 20px;
        }
        .no-data-message {
            text-align: center;
            font-size: 1.5rem;
            color: #777;
        }
    </style>



<div class="container mt-5">
        <div class="card shadow mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">Analisis Layanan</h6>
                <div class="d-flex ml-auto">
                    <div class="form-inline mr-3">
                        <div class="form-group">
                            <label for="bulan" class="mr-2 font-weight-bold text-primary" >Filter Bulan:</label>
                            <input type="month" name="bulan" id="bulan" class="form-control" value="{{ $bulan }}">
                        </div>
                    </div>
                    
                    <style>
                        .separator {
                                border-left: 1px solid #d1d1d1; /* Warna garis samar */
                                height: 30px; /* Tinggi garis, sesuaikan dengan kebutuhan */
                                margin: 0 10px; /* Jarak kiri dan kanan garis */
                                margin-top: 5px;
                                display: inline-block; /* Agar elemen tampil sejajar dengan tombol */
                            }
                    </style>
                    
                    <div class="separator"></div>

                    <div class="dropdown no-arrow ml-2" style="margin-top: 13px">
                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                            aria-labelledby="dropdownMenuLink">
                            <div class="dropdown-header">Action:</div>
                            <button class="dropdown-item" data-toggle="modal" data-target="#exportModal">Export Semua Data Layanan</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div id="no-data-message" class="no-data-message" style="display: none;">
                    Data belum tersedia, silahkan tambahkan untuk bulan ini dahulu!
                </div>
                <div id="charts-and-table" style="display: none;">
                    <div class="chart-container mb-4">
                        <canvas id="barChart"></canvas>
                    </div>
                    <div class="flex-container">
                        <div class="chart chart-half">
                            <canvas id="pieChart"></canvas>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Nama Layanan</th>
                                        <th>Jumlah Layanan</th>
                                    </tr>
                                </thead>
                                <tbody id="data-table-body">
                                    <!-- Data akan dimuat di sini melalui AJAX -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal Export Semua Data Service Pasien Start -->

    <div class="modal fade" id="exportModal" tabindex="-1" role="dialog" aria-labelledby="exportModallLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exportModallLabel">Export Data Kunjungan Pasien</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                    <div class="modal-body">
                            <label>Anda yakin untuk mengeksport Data Kunjungan Pasien?</label>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <a href="{{ route('export.kunjungan') }}"><button type="button" class="btn btn-primary">Export</button></a>
                    </div>
            </div>
        </div>
    </div>

    <!-- Modal Export Semua Data Service Pasien End -->


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var dataPerService = [];
            var ctxBar = document.getElementById('barChart').getContext('2d');
            var ctxPie = document.getElementById('pieChart').getContext('2d');
            var barChart;
            var pieChart;

            function updateChartAndTable(data) {
                if (data.length === 0) {
                    document.getElementById('no-data-message').style.display = 'block';
                    document.getElementById('charts-and-table').style.display = 'none';
                    return;
                } else {
                    document.getElementById('no-data-message').style.display = 'none';
                    document.getElementById('charts-and-table').style.display = 'block';
                }

                // Update dataPerService
                dataPerService = data;

                // Update Chart
                var labels = dataPerService.map(data => data.service.service);
                var data = dataPerService.map(data => data.jumlah_service);
                var backgroundColors = generateColors(data.length);

                if (barChart) {
                    barChart.destroy();
                }
                if (pieChart) {
                    pieChart.destroy();
                }

                barChart = new Chart(ctxBar, {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Jumlah Layanan',
                            data: data,
                            backgroundColor: backgroundColors,
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });

                pieChart = new Chart(ctxPie, {
                    type: 'pie',
                    data: {
                        labels: labels,
                        datasets: [{
                            data: data,
                            backgroundColor: backgroundColors,
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false
                    }
                });

                // Update Table
                var tableBody = document.getElementById('data-table-body');
                tableBody.innerHTML = '';
                dataPerService.forEach((data, index) => {
                    var row = `<tr>
                        <td>${index + 1}</td>
                        <td>${data.service.service}</td>
                        <td>${data.jumlah_service}</td>
                    </tr>`;
                    tableBody.innerHTML += row;
                });
            }

            function generateColors(numColors) {
                var colors = [
                    '#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF', '#FF9F40',
                    '#C9CBCF', '#76C7C0', '#FF80AB', '#FF4081', '#FFAB91', '#FF8A65',
                    '#BA68C8', '#9575CD', '#7986CB', '#4FC3F7', '#4DB6AC', '#81C784',
                    '#AED581', '#FFEB3B', '#FFC107', '#FF7043', '#8D6E63', '#BDBDBD',
                    '#90A4AE', '#E53935', '#D81B60', '#8E24AA', '#5E35B1', '#3949AB',
                    '#1E88E5', '#039BE5', '#00ACC1', '#00897B', '#43A047', '#7CB342',
                    '#C0CA33', '#FDD835', '#FFB300', '#FB8C00', '#F4511E', '#6D4C41',
                    '#757575', '#546E7A'
                ];
                return colors.slice(0, numColors);
            }

            function fetchData(bulan) {
                $.ajax({
                    url: '{{ route("analisis.service.data") }}',
                    method: 'GET',
                    data: { bulan: bulan },
                    success: function(response) {
                        updateChartAndTable(response);
                    }
                });
            }

            // Fetch data for the current month on page load
            var currentMonth = $('#bulan').val();
            fetchData(currentMonth);

            // Fetch data when the month is changed
            $('#bulan').on('change', function () {
                var bulan = $(this).val();
                fetchData(bulan);
            });
        });
    </script>


@endsection