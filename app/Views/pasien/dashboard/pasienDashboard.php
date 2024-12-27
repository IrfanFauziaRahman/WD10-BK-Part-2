    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Dashboard Pasien</h1>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <!-- Info Cards -->
            <div class="row">
                <!-- Nomor Rekam Medis -->
                <div class="col-md-3 col-sm-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <p class="mb-1">NOMOR REKAM MEDIS</p>
                            <h3><?= $pasien['no_rm'] ?? '-' ?></h3>
                        </div>
                        <div class="icon">
                            <i class="fas fa-id-card"></i>
                        </div>
                    </div>
                </div>

                <!-- Total Kunjungan -->
                <div class="col-md-3 col-sm-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <p class="mb-1">TOTAL KUNJUNGAN</p>
                            <h3><?= $total_kunjungan ?></h3>
                        </div>
                        <div class="icon">
                            <i class="fas fa-check-circle"></i>
                        </div>
                    </div>
                </div>

                <!-- Antrian Aktif -->
                <div class="col-md-3 col-sm-6">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <p class="mb-1">ANTRIAN AKTIF</p>
                            <h3><?= $antrian_aktif ?></h3>
                        </div>
                        <div class="icon">
                            <i class="fas fa-user-clock"></i>
                        </div>
                    </div>
                </div>

                <!-- Kunjungan Terakhir -->
                <div class="col-md-3 col-sm-6">
                    <div class="small-box bg-info" style="background-color: #17a2b8 !important;">
                        <div class="inner">
                            <p class="mb-1">KUNJUNGAN TERAKHIR</p>
                            <h3><?= $kunjungan_terakhir ?></h3>
                        </div>
                        <div class="icon">
                            <i class="fas fa-calendar-alt"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- Riwayat Kunjungan -->
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="mb-3">Riwayat Kunjungan</h5>
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Tanggal</th>
                                            <th>Poli</th>
                                            <th>Dokter</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (empty($riwayat_poli)): ?>
                                        <tr>
                                            <td colspan="4" class="text-center">Tidak ada riwayat kunjungan</td>
                                        </tr>
                                        <?php else: ?>
                                            <?php foreach ($riwayat_poli as $riwayat): ?>
                                            <tr>
                                                <td><?= date('d/m/Y', strtotime($riwayat['created_at'])) ?></td>
                                                <td><?= $riwayat['nama_poli'] ?></td>
                                                <td><?= $riwayat['nama_dokter'] ?></td>
                                                <td>
                                                    <?php
                                                    $statusBadge = [
                                                        'menunggu' => 'badge-warning',
                                                        'diperiksa' => 'badge-info',
                                                        'selesai' => 'badge-success'
                                                    ];
                                                    ?>
                                                    <span class="badge <?= $statusBadge[$riwayat['status']] ?>">
                                                        <?= ucfirst($riwayat['status']) ?>
                                                    </span>
                                                </td>
                                            </tr>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Informasi Poli -->
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="mb-3">Informasi Poli</h5>
                            <?php foreach ($dokter_per_poli as $poli): ?>
                            <div class="d-flex justify-content-between align-items-center mb-3 pb-2 border-bottom">
                                <div>
                                    <h6 class="mb-1"><?= $poli['nama_poli'] ?></h6>
                                    <small class="text-muted">Dokter <?= strtolower(str_replace('Poli ', '', $poli['nama_poli'])) ?></small>
                                </div>
                                <button class="btn btn-primary btn-sm">
                                    <?= $poli['jumlah_dokter'] ?> Dokter
                                </button>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<style>
.small-box {
    border-radius: 10px;
    position: relative;
    display: block;
    margin-bottom: 20px;
    box-shadow: 0 1px 1px rgba(0,0,0,0.1);
}

.small-box > .inner {
    padding: 20px;
}

.small-box > .inner p {
    font-size: 14px;
    font-weight: bold;
    margin: 0;
    color: white;
}

.small-box h3 {
    font-size: 20px;
    font-weight: bold;
    color: white;
}

.small-box .icon {
    position: absolute;
    top: 10px;
    right: 10px;
    font-size: 16px;
    color: rgba(255,255,255,0.3);
}

.card {
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0,0,0,0.1);
    border: none;
}

.table thead th {
    border-top: none;
    border-bottom-width: 1px;
    font-weight: 500;
    color: #333;
}

.btn-primary {
    border-radius: 5px;
    padding: 4px 12px;
}

.small-box.bg-info { background-color: #00B5D8 !important; }
.small-box.bg-success { background-color: #38B2AC !important; }
.small-box.bg-warning { background-color: #FBBF24 !important; }
</style>