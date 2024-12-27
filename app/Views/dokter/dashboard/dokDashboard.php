<div class="container-fluid py-4">
    <!-- Welcome Banner -->
    <div class="card bg-primary text-white mb-4 shadow">
        <div class="card-body p-4">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="mb-1">Selamat Datang, Dr. <?= $dokter['nama_dokter'] ?></h4>
                    <p class="mb-0"><?= $dokter['nama_poli'] ?></p>
                </div>
                <i class="bi bi-person-badge fs-1"></i>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Pasien</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $totalPasien ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-people fs-2 text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Antrian Hari Ini</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= count($antrianHariIni) ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-clock-history fs-2 text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Pasien Minggu Ini</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $pasienSeminggu ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-calendar-week fs-2 text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Grafik Kunjungan Pasien (7 Hari Terakhir)</h6>
        </div>
        <div class="card-body">
            <div class="chart-area">
                <canvas id="myChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Antrian Table -->
    <?php if(!empty($antrianHariIni)): ?>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Antrian Hari Ini</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No. Antrian</th>
                            <th>Nama Pasien</th>
                            <th>No. RM</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($antrianHariIni as $antrian): ?>
                        <tr>
                            <td><?= $antrian['no_antrian'] ?></td>
                            <td><?= $antrian['nama_pasien'] ?></td>
                            <td><?= $antrian['no_rm'] ?></td>
                            <td>
                                <a href="/dokter/memeriksa/mulai/<?= $antrian['id'] ?>" 
                                   class="btn btn-warning btn-sm">
                                    <i class="bi bi-stethoscope me-1"></i>
                                    Periksa
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>

<style>
.border-left-primary {
    border-left: .25rem solid #4e73df!important;
}
.border-left-success {
    border-left: .25rem solid #1cc88a!important;
}
.border-left-warning {
    border-left: .25rem solid #f6c23e!important;
}
.text-gray-300 {
    color: #dddfeb!important;
}
.chart-area {
    position: relative;
    height: 20rem;
    width: 100%;
}
</style>

<!-- Chart.js Script -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var ctx = document.getElementById('myChart');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: <?= json_encode($chartData['labels']) ?>,
            datasets: [{
                label: 'Jumlah Pasien',
                data: <?= json_encode($chartData['data']) ?>,
                borderColor: '#4e73df',
                tension: 0.3,
                fill: false
            }]
        },
        options: {
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            },
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    });
});
</script>