@extends('layouts.app')

@section('content')
    <header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-10">
        <div class="container-xl px-4">
            <div class="page-header-content pt-4">
                <div class="row align-items-center justify-content-between">
                    <div class="col-auto mt-4">
                        <h1 class="page-header-title">
                            <div class="page-header-icon"><i data-feather="activity"></i></div>
                            Dashboard
                        </h1>
                        <div class="page-header-subtitle">Example dashboard overview and content summary</div>
                    </div>
                    <div class="col-12 col-xl-auto mt-4">

                        <div class="input-group input-group-joined border-0" style="width: 18.5rem">
                            <div class="input-group input-group-joined border-0" style="width: 16.5rem">
                                <span class="input-group-text"><i class="text-primary" data-feather="calendar"></i></span>
                                <input class="form-control ps-0 pointer" id="monthPicker" type="month"
                                    placeholder="Select date range..." />
                                {{-- <button type="button" id="filter-dashboard" class="btn btn-primary">Tampilkan
                            </button> --}}
                            </div>

                            {{-- <div class="row">
                            <div class="col-md-6">
                                <label for="monthPicker" class="form-label">Pilih Bulan:</label>

                                <input type="month" id="monthPicker" name="monthPicker" class="form-select">
                            </div>
                            <div class="col-md-2 d-flex align-items-end">
                                <button type="button" id="filter-dashboard" class="btn btn-primary">Tampilkan
                                </button>
                            </div>
                        </div> --}}


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- Main page content-->
    <div class="container-xl px-4 mt-n10">
        <div class="row justify-content-center">
            <div class="col-md-12">


                <div class="row">
                    <div class="col-lg-6 col-xl-3 mb-4">
                        <div class="card bg-primary text-white h-100">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="me-3">
                                        <div class="text-white-75 small">Income</div>
                                        <div id="income" class="text-lg fw-bold"></div>
                                    </div>
                                    <i class="feather-xl text-white-50" data-feather="calendar"></i>
                                </div>
                            </div>
                            <div class="card-footer d-flex align-items-center justify-content-between small">
                                <a class="text-white stretched-link" href="#!">View Report</a>
                                <div class="text-white"><i class="fas fa-angle-right"></i></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-xl-3 mb-4">
                        <div class="card bg-warning text-white h-100">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="me-3">
                                        <div class="text-white-75 small">Expense</div>
                                        <div id="expense" class="text-lg fw-bold"></div>
                                    </div>
                                    <i class="feather-xl text-white-50" data-feather="dollar-sign"></i>
                                </div>
                            </div>
                            <div class="card-footer d-flex align-items-center justify-content-between small">
                                <a class="text-white stretched-link" href="#!">View Report</a>
                                <div class="text-white"><i class="fas fa-angle-right"></i></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-xl-3 mb-4">
                        <div class="card bg-success text-white h-100">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="me-3">
                                        <div class="text-white-75 small">Balance</div>
                                        <div id="balance" class="text-lg fw-bold"></div>
                                    </div>
                                    <i class="feather-xl text-white-50" data-feather="check-square"></i>
                                </div>
                            </div>
                            <div class="card-footer d-flex align-items-center justify-content-between small">
                                <a class="text-white stretched-link" href="#!">View Report</a>
                                <div class="text-white"><i class="fas fa-angle-right"></i></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-xl-3 mb-4">
                        <div class="card bg-secondary  text-white h-100">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="me-3">
                                        <div class="text-white-75 small">Net</div>
                                        <div id="net" class="text-lg fw-bold"></div>
                                    </div>
                                    <i class="feather-xl text-white-50" data-feather="message-circle"></i>
                                </div>
                            </div>
                            <div class="card-footer d-flex align-items-center justify-content-between small">
                                <a class="text-white stretched-link" href="#!">View Report</a>
                                <div class="text-white"><i class="fas fa-angle-right"></i></div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Hasil akan ditampilkan di sini -->

                <!-- Example Charts for Dashboard Demo-->
                <div class="row">
                    <div class="col-md-6 mb-4">
                        <div class="card card-header-actions">
                            <div class="card-header">
                                Income
                            </div>
                            <div class="card-body">
                                <div class="chart-area">
                                    <canvas id="incomeChart" width="100%" height="100%"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-4">
                        <div class="card card-header-action">
                            <div class="card-header">
                                Expense
                            </div>
                            <div class="card-body">
                                <div class="chart-area">
                                    <canvas id="expenseChart" width="100%" height="100%"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Hasil akan ditampilkan di sini -->

                <!-- Example Charts for Dashboard Demo-->
                <div class="row">
                    <div class="col-md-6 mb-4">
                        <div class="card card-header-actions">
                            <div class="card-header">
                                Payment Method Income
                            </div>
                            <div class="card-body">
                                <div class="chart-bar">
                                    <canvas id="paymentMethodIncomeChart" width="100%" height="100%"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 mb-4">
                        <div class="card card-header-actions">
                            <div class="card-header">
                                Payment Method Expense

                            </div>
                            <div class="card-body">
                                <div class="chart-bar">
                                    <canvas id="paymentMethodExpenseChart" width="100%" height="100%"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    @endsection
    @section('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script>
            function setDefaultMonthYear() {
                const today = new Date();
                const month = String(today.getMonth() + 1).padStart(2, '0'); // Get month (0-indexed, so add 1)
                const year = today.getFullYear();
                const defaultValue = `${year}-${month}`;

                // Set default value in the month picker input
                $('#monthPicker').val(defaultValue);
                setData();
            }

            function setData() {
                const value = $('#monthPicker').val(); // Get the value in 'YYYY-MM' format
                const [year, month] = value.split('-'); // Split the value into year and month
                console.log('Selected Year:', year);
                console.log('Selected Month:', month);
                $.ajax({
                    url: `/financial-data/${year}/${month}`,
                    method: 'GET',
                    success: function(data) {
                        console.log(data)
                        drawCharts(data.labels, data.incomeData, data.expenseData);
                        pieChart(data.payment_method_labels, data.payment_method_income, data
                            .payment_method_expense)
                        $('#income').text(`Rp ${data.total_income} `);
                        $('#expense').text(`Rp ${data.total_expense} `);
                        $('#balance').text(`Rp ${data.cash_balance} `);
                        $('#net').text(`${data.net_cashflow} `);

                    },
                    error: function(error) {
                        // Tampilkan pesan error jika API gagal
                        $('#dashboard-results').html(`
                        <div class="alert alert-danger">Terjadi kesalahan, tidak bisa memuat data.</div>
                    `);
                    }
                })
            }
            $(document).ready(function() {
                setDefaultMonthYear();
                $('#monthPicker').on('change', setData);
            })
            // Buat permintaan AJAX ke API

            function pieChart(payment_method_labels, payment_method_income, payment_method_expense) {
                let incomeCtxStatus = Chart.getChart("paymentMethodIncomeChart"); // <canvas> id
                if (incomeCtxStatus != undefined) {
                    incomeCtxStatus.destroy();
                }
                var incomeCtx = document.getElementById('paymentMethodIncomeChart').getContext('2d');

                var paymentMethodIncomeChart = new Chart(incomeCtx, {
                    type: 'doughnut',
                    data: {
                        labels: payment_method_labels,
                        datasets: [{
                            label: 'Total Pemasukan',
                            data: payment_method_income,
                            backgroundColor: [
                                'rgba(75, 192, 192, 0.2)',
                                'rgba(54, 162, 235, 0.2)',
                                'rgba(255, 206, 86, 0.2)',
                                'rgba(153, 102, 255, 0.2)',
                                'rgba(255, 159, 64, 0.2)',
                                'rgba(255, 99, 132, 0.2)',
                            ],
                            borderColor: [
                                'rgba(75, 192, 192, 1)',
                                'rgba(54, 162, 235, 1)',
                                'rgba(255, 206, 86, 1)',
                                'rgba(153, 102, 255, 1)',
                                'rgba(255, 159, 64, 1)',
                                'rgba(255, 99, 132, 1)',
                            ],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        plugins: {
                            // tooltip: {
                            //     callbacks: {
                            //         label: function(tooltipItem) {
                            //             let label = tooltipItem.label || '';
                            //             let value = tooltipItem.raw; // Mengambil nilai asli

                            //             // Format Rupiah
                            //             let formattedValue = new Intl.NumberFormat('id-ID', {
                            //                 style: 'currency',
                            //                 currency: 'IDR',
                            //                 minimumFractionDigits: 0
                            //             }).format(value);
                            //             console.log( label + ': ' + formattedValue)
                            //             return label + ': ' + formattedValue;
                            //         }
                            //     }
                            datalabels: {
                                formatter: (value) => {
                                    return value + '%';
                                },
                            },

                        }
                    }
                });

                let chartStatus = Chart.getChart("paymentMethodExpenseChart"); // <canvas> id
                if (chartStatus != undefined) {
                    chartStatus.destroy();
                }

                // Tampilkan pie chart untuk pengeluaran berdasarkan metode pembayaran
                var expenseCtx = document.getElementById('paymentMethodExpenseChart').getContext('2d');
                var paymentMethodExpenseChart = new Chart(expenseCtx, {
                    type: 'doughnut',
                    data: {
                        labels: payment_method_labels,
                        datasets: [{
                            label: 'Total Pengeluaran',
                            data: payment_method_expense,
                            backgroundColor: [
                                'rgba(255, 99, 132, 0.2)',
                                'rgba(255, 159, 64, 0.2)',
                                'rgba(255, 206, 86, 0.2)',
                                'rgba(75, 192, 192, 0.2)',
                                'rgba(54, 162, 235, 0.2)',
                                'rgba(153, 102, 255, 0.2)',
                            ],
                            borderColor: [
                                'rgba(255, 99, 132, 1)',
                                'rgba(255, 159, 64, 1)',
                                'rgba(255, 206, 86, 1)',
                                'rgba(75, 192, 192, 1)',
                                'rgba(54, 162, 235, 1)',
                                'rgba(153, 102, 255, 1)',
                            ],
                            borderWidth: 1
                        }]
                    }

                })
            }
            // Fungsi untuk menggambar chart
            function drawCharts(labels, incomeData, expenseData) {
                // Cari nilai maksimum dari kedua dataset
                const maxIncome = Math.max(...incomeData);
                const maxExpense = Math.max(...expenseData);
                const maxYValue = Math.max(maxIncome, maxExpense);
                // Hapus chart jika sudah ada sebelumnya
                let incomeChartStatus = Chart.getChart("incomeChart");
                if (incomeChartStatus != undefined) {
                    incomeChartStatus.destroy();
                }
                let expenseChartStatus = Chart.getChart("expenseChart");
                if (expenseChartStatus != undefined) {
                    expenseChartStatus.destroy();
                }

                // Chart untuk Income
                const incomeCtx = document.getElementById('incomeChart').getContext('2d');
                new Chart(incomeCtx, {
                    type: 'line',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Income',
                            data: incomeData,
                            borderColor: 'rgba(75, 192, 192, 1)',
                            backgroundColor: 'rgba(75, 192, 192, 0.2)',
                            fill: true,
                            tension: 0.1
                        }]
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
                                    text: 'Jumlah Income (Rp)'
                                },
                                beginAtZero: true,
                                max: maxYValue
                            }
                        }
                    }
                });

                // Chart untuk Expense
                const expenseCtx = document.getElementById('expenseChart').getContext('2d');
                new Chart(expenseCtx, {
                    type: 'line',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Expense',
                            data: expenseData,
                            borderColor: 'rgba(255, 99, 132, 1)',
                            backgroundColor: 'rgba(255, 99, 132, 0.2)',
                            fill: true,
                            tension: 0.1
                        }]
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
                                    text: 'Jumlah Expense (Rp)'
                                },
                                beginAtZero: true,
                                max: maxYValue
                            }
                        }
                    }
                });
            }


            // Contoh penggunaan API untuk bulan Oktober 2024
            // getFinancialData(2024, 10);
        </script>
    @endsection
