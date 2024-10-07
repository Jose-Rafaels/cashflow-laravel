@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>
                <canvas id="financialChart" width="400" height="200"></canvas>

                <div class="card-body">
                    {{ __("You're logged in!") }}
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    // Fungsi untuk mengambil data dari API berdasarkan tahun dan bulan
    function getFinancialData(year, month) {
        $.ajax({
            url: `/financial-data/${year}/${month}`,
            method: 'GET',
            success: function(response) {
                console.log(response.labels)
                drawChart(response.labels, response.incomeData, response.expenseData);
            }
        });
    }

    // Fungsi untuk menggambar chart
    function drawChart(labels, incomeData, expenseData) {
        const ctx = document.getElementById('financialChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [
                    {
                        label: 'Income',
                        data: incomeData,
                        borderColor: 'rgba(75, 192, 192, 1)',
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        fill: true,
                        tension: 0.1
                    },
                    {
                        label: 'Expense',
                        data: expenseData,
                        borderColor: 'rgba(255, 99, 132, 1)',
                        backgroundColor: 'rgba(255, 99, 132, 0.2)',
                        fill: true,
                        tension: 0.1
                    }
                ]
            },
            options: {
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'Tanggal'
                        }
                    },
                    y: {
                        title: {
                            display: true,
                            text: 'Jumlah Transaksi (Rp)'
                        },
                        beginAtZero: true
                    }
                }
            }
        });
    }

    // Contoh penggunaan API untuk bulan Oktober 2024
    getFinancialData(2024, 10);
</script>
@endsection