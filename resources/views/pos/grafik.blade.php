<!-- Component Grafik Penjualan -->
<div class="card border-0 shadow-sm rounded-4 p-4 mb-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h5 class="fw-bold mb-0">Grafik Penjualan</h5>
            <small class="text-muted">Ringkasan omset penjualan seminggu terakhir</small>
        </div>
        <span class="badge bg-danger-subtle text-danger px-3 py-2 rounded-pill fw-semibold">Mingguan</span>
    </div>
    <div style="height: 250px;">
        <canvas id="chartPenjualanPOS"></canvas>
    </div>
</div>

<!-- Library Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const ctx = document.getElementById('chartPenjualanPOS').getContext('2d');
    
    // Gradient Background Warna Merah Khas POS
    let gradient = ctx.createLinearGradient(0, 0, 0, 200);
    gradient.addColorStop(0, 'rgba(255, 77, 77, 0.4)');
    gradient.addColorStop(1, 'rgba(255, 77, 77, 0.0)');

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'],
            datasets: [{
                label: 'Omset Penjualan (Rp)',
                data: [120000, 250000, 180000, 310000, 280000, 450000, 0],
                borderColor: '#ff4d4d',
                borderWidth: 3,
                backgroundColor: gradient,
                fill: true,
                tension: 0.4,
                pointBackgroundColor: '#ff4d4d',
                pointRadius: 5
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: { color: '#f0f0f0' },
                    ticks: {
                        callback: function(value) {
                            return 'Rp ' + value.toLocaleString('id-ID');
                        }
                    }
                },
                x: {
                    grid: { display: false }
                }
            }
        }
    });
});
</script>