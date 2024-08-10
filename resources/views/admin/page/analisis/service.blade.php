
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
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4>Analisis Layanan</h4>
                <div class="form-inline">
                    <div class="form-group">
                        <label for="bulan" class="mr-2">Filter Bulan:</label>
                        <input type="month" name="bulan" id="bulan" class="form-control" value="{{ $bulan }}">
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