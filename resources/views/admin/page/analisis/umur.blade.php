
@extends('template-dashboard')
 @section('dashboard')

    <style>
        .chart-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100%;
        }
        .chart {
            width: 400px;
            margin: 0px;
        }
    </style>

 <div class="container">
        <div class="card">
            <div class="card-body">
                <div class="chart-container">
                    <!-- Grafik Lingkaran -->
                    <div class="chart">
                        <canvas id="pieChart"></canvas>
                    </div>
                    <!-- Grafik Balok -->
                    <div class="chart">
                        <canvas id="barChart"></canvas>
                    </div>
                </div>
                <!-- Tabel Penjelasan Detail -->
                <div class="mt-4">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Range Umur</th>
                                <th>Jumlah Pasien</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($ageRanges as $range => $count)
                            <tr>
                                <td>{{ $range }}</td>
                                <td>{{ $count }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var ageRanges = @json($ageRanges);

            // Data untuk grafik
            var labels = Object.keys(ageRanges);
            var data = Object.values(ageRanges);

            // Grafik Lingkaran
            var ctxPie = document.getElementById('pieChart').getContext('2d');
            var pieChart = new Chart(ctxPie, {
                type: 'pie',
                data: {
                    labels: labels,
                    datasets: [{
                        data: data,
                        backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF'],
                    }]
                },
                options: {
                    responsive: true
                }
            });

            // Grafik Balok
            var ctxBar = document.getElementById('barChart').getContext('2d');
            var barChart = new Chart(ctxBar, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Jumlah Pasien',
                        data: data,
                        backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF'],
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
        });
    </script>

@endsection