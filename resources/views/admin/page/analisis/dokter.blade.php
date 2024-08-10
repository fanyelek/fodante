
@extends('template-dashboard')
 @section('dashboard')


 <div class="container mt-5">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4>Analisis Layanan Dokter</h4>
                <div class="form-inline">
                    <div class="form-group">
                        <label for="bulan" class="mr-2">Filter Bulan:</label>
                        <input type="month" name="bulan" id="bulan" class="form-control" value="{{ $bulan }}">
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="chart-container mb-4">
                    <canvas id="barChart"></canvas>
                    <div id="no-chart-data-message" class="text-center" style="display: none;">
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Nama Dokter</th>
                                <th>Jumlah Layanan</th>
                            </tr>
                        </thead>
                        <tbody id="data-table-body">
                            <!-- Data akan dimuat di sini melalui AJAX -->
                        </tbody>
                        <tfoot id="no-data-message" style="display: none;">
                            <tr>
                                <td colspan="3" class="text-center">Belum ada data untuk bulan ini, masukkan data dahulu!</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var dataPerDokter = [];
            var ctxBar = document.getElementById('barChart').getContext('2d');
            var barChart;

            function updateChartAndTable(data) {
            // Update dataPerDokter
            dataPerDokter = data;

            // Update Chart
            var labels = dataPerDokter.map(data => data.nama_dokter);
            var data = dataPerDokter.map(data => data.jumlah_layanan);

            var noChartDataMessage = document.getElementById('no-chart-data-message');
            var ctxBar = document.getElementById('barChart').getContext('2d');

            if (barChart) {
                barChart.destroy();
            }

            if (dataPerDokter.length > 0) {
                noChartDataMessage.style.display = 'none';
                document.getElementById('barChart').style.display = 'block';

                barChart = new Chart(ctxBar, {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Jumlah Layanan',
                            data: data,
                            backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF', '#FF9F40'],
                        }]
                    },
                    options: {
                        responsive: true,
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            } else {
                noChartDataMessage.style.display = 'block';
                document.getElementById('barChart').style.display = 'none';
            }

            // Update Table
            var tableBody = document.getElementById('data-table-body');
            var noDataMessage = document.getElementById('no-data-message');
            tableBody.innerHTML = '';

            if (dataPerDokter.length > 0) {
                noDataMessage.style.display = 'none';
                dataPerDokter.forEach((data, index) => {
                    var row = `<tr>
                        <td>${index + 1}</td>
                        <td>${data.nama_dokter}</td>
                        <td>${data.jumlah_layanan}</td>
                    </tr>`;
                    tableBody.innerHTML += row;
                });
            } else {
                noDataMessage.style.display = 'table-row-group';
            }
        }

            function fetchData(bulan) {
                $.ajax({
                    url: '{{ route("analisis.dentist") }}',
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