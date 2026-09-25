<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Grafik Penjualan - Ayam Geprek</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            background-color: #f4f6f9;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .header-dashboard {
            background: linear-gradient(135deg, #ff4d4d, #ff1a1a);
            color: white;
            padding: 15px 25px;
            border-bottom-left-radius: 20px;
            border-bottom-right-radius: 20px;
        }
        .btn-hover-nimbul {
            transition: all 0.25s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }
        .btn-hover-nimbul:hover {
            transform: translateY(-4px) scale(1.03);
            box-shadow: 0 8px 18px rgba(255, 77, 77, 0.25) !important;
        }
        .card-stat {
            border: none;
            border-radius: 16px;
            transition: transform 0.2s;
        }
        .card-stat:hover {
            transform: translateY(-4px);
        }
    </style>
</head>
<body>

    <!-- HEADER / TOPBAR -->
    <div class="header-dashboard d-flex justify-content-between align-items-center shadow-sm mb-4">
        <div class="d-flex align-items-center gap-3">
            <h4 class="fw-bold mb-0"><i class="fa-solid fa-chart-line me-2"></i>Dashboard Penjualan</h4>
        </div>
        <div class="d-flex align-items-center gap-2">
            <!-- Filter Tanggal Interaktif Dashboard -->
            <div class="bg-white text-danger px-3 py-1 rounded-pill shadow-sm d-flex align-items-center gap-2">
                <i class="fa-regular fa-calendar-days"></i>
                <input type="date" id="filterDate" class="border-0 bg-transparent text-danger fw-bold shadow-none" style="outline: none; font-size: 0.9rem;" onchange="updateDashboardData()">
            </div>

            <a href="<?php echo route('pos.index'); ?>" class="btn btn-light text-danger rounded-pill fw-bold btn-sm px-3 ms-1 btn-hover-nimbul">
                <i class="fa-solid fa-cash-register me-1"></i> Kembali ke Kasir POS
            </a>
            <a href="<?php echo route('login'); ?>" class="btn btn-outline-light rounded-pill btn-sm px-3 ms-1 btn-hover-nimbul" onclick="return confirm('Yakin ingin keluar?')">
                <i class="fa-solid fa-right-from-bracket"></i>
            </a>
        </div>
    </div>

    <!-- MAIN CONTENT -->
    <div class="container-fluid px-4">
        
        <!-- ROW RINGKASAN HARIAN (Dibuat jadi 2 kolom karena Menu Terlaris dihapus) -->
        <div class="row g-3 mb-4">
            <div class="col-md-6">
                <div class="card card-stat shadow-sm p-3 bg-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <small class="text-muted fw-semibold">Total Omset Hari Ini</small>
                            <h4 class="fw-bold text-danger mb-0 mt-1" id="statOmset">Rp 0</h4>
                        </div>
                        <div class="bg-danger-subtle text-danger p-3 rounded-circle">
                            <i class="fa-solid fa-money-bill-wave fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card card-stat shadow-sm p-3 bg-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <small class="text-muted fw-semibold">Transaksi Hari Ini</small>
                            <h4 class="fw-bold text-dark mb-0 mt-1" id="statTrx">0 Pesanan</h4>
                        </div>
                        <div class="bg-primary-subtle text-primary p-3 rounded-circle">
                            <i class="fa-solid fa-receipt fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ROW GRAFIK -->
        <div class="row g-4 mb-4">
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm rounded-4 p-4 bg-white h-100">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="fw-bold text-dark mb-0"><i class="fa-solid fa-chart-area text-danger me-2"></i>Tren Omset Penjualan</h5>
                        <span class="badge bg-danger-subtle text-danger rounded-pill px-3 py-2">Otomatis Tanggal Pilihan</span>
                    </div>
                    <div style="height: 320px;">
                        <canvas id="grafikOmset"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card border-0 shadow-sm rounded-4 p-4 bg-white h-100">
                    <h5 class="fw-bold text-dark mb-3"><i class="fa-solid fa-chart-pie text-danger me-2"></i>Persentase Kategori</h5>
                    <div style="height: 280px;" class="d-flex justify-content-center align-items-center">
                        <canvas id="grafikKategori"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- ROW TAMBAHAN: TOTAL OMSET BULANAN -->
        <div class="row g-4 mb-5">
            <div class="col-12">
                <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="fw-bold text-dark mb-1"><i class="fa-solid fa-calendar-alt text-danger me-2"></i>Total Omset Bulan Ini</h5>
                            <small class="text-muted">Akumulasi total penjualan otomatis per bulan berdasarkan data kasir.</small>
                        </div>
                        <h3 class="fw-bold text-success mb-0" id="statMonthlyOmset">Rp 0</h3>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Script Chart.js & Dinamis Filter Tanggal & Nama Hari Normal -->
    <script>
    let omsetChart, kategoriChart;

    document.addEventListener("DOMContentLoaded", function () {
        const todayStr = new Date().toISOString().slice(0, 10);
        document.getElementById('filterDate').value = todayStr;

        initCharts();
        updateDashboardData();
    });

    function formatRupiah(number) {
        return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', maximumFractionDigits: 0 }).format(number);
    }

    function updateDashboardData() {
        const selectedDateStr = document.getElementById('filterDate').value;
        const selectedDate = new Date(selectedDateStr);
        const selectedMonth = selectedDateStr.slice(0, 7);

        let historyList = JSON.parse(localStorage.getItem('pos_history')) || [];

        let dailyOmset = 0;
        let dailyTrx = 0;
        let monthlyOmset = 0;

        historyList.forEach(trx => {
            if (trx.monthKey === selectedMonth) {
                monthlyOmset += trx.total;
            }
            if (trx.dateKey === selectedDateStr) {
                dailyOmset += trx.total;
                dailyTrx += 1;
            }
        });

        document.getElementById('statOmset').innerText = formatRupiah(dailyOmset);
        document.getElementById('statTrx').innerText = dailyTrx + ' Pesanan';
        document.getElementById('statMonthlyOmset').innerText = formatRupiah(monthlyOmset);

        let labels = [];
        let dataValues = [];

        for (let i = -3; i <= 3; i++) {
            let d = new Date(selectedDate);
            d.setDate(selectedDate.getDate() + i);
            
            let dayName = d.toLocaleDateString('id-ID', { weekday: 'long' });
            let dateKey = d.toISOString().slice(0, 10);

            labels.push(dayName);

            let totalOnThisDay = 0;
            historyList.forEach(trx => {
                if (trx.dateKey === dateKey) {
                    totalOnThisDay += trx.total;
                }
            });

            if (i === 0) {
                dataValues.push(dailyOmset);
            } else {
                dataValues.push(totalOnThisDay);
            }
        }

        if (omsetChart) {
            omsetChart.data.labels = labels;
            omsetChart.data.datasets[0].data = dataValues;
            omsetChart.update();
        }
    }

    function initCharts() {
        const ctxOmset = document.getElementById('grafikOmset').getContext('2d');
        omsetChart = new Chart(ctxOmset, {
            type: 'line',
            data: {
                labels: ['', '', '', '', '', '', ''],
                datasets: [{
                    label: 'Omset (Rp)',
                    data: [0, 0, 0, 0, 0, 0, 0],
                    borderColor: '#ff4d4d',
                    backgroundColor: 'rgba(255, 77, 77, 0.15)',
                    fill: true,
                    tension: 0.4,
                    borderWidth: 3,
                    pointRadius: 6,
                    pointBackgroundColor: '#ff4d4d'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) { return 'Rp ' + value.toLocaleString('id-ID'); }
                        }
                    }
                }
            }
        });

        const ctxKategori = document.getElementById('grafikKategori').getContext('2d');
        kategoriChart = new Chart(ctxKategori, {
            type: 'doughnut',
            data: {
                labels: ['Makanan', 'Minuman', 'Cemilan'],
                datasets: [{
                    data: [70, 20, 10],
                    backgroundColor: ['#ff4d4d', '#ffc107', '#0d6efd'],
                    borderWidth: 2,
                    hoverOffset: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { position: 'bottom' } }
            }
        });
    }
    </script>
</body>
</html>