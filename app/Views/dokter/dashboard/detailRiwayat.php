<div class="container my-5">
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h3 class="mb-0">Detail Riwayat Periksa</h3>
                <a href="/dokter/riwayat" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
            </div>
        </div>
        <div class="card-body">
            <!-- Informasi Pasien -->
            <div class="row mb-4">
                <div class="col-md-6">
                    <h5 class="border-bottom pb-2">Informasi Pasien</h5>
                    <table class="table table-borderless">
                        <tr>
                            <td width="30%">Nama Pasien</td>
                            <td width="5%">:</td>
                            <td><?= $riwayat['nama_pasien'] ?></td>
                        </tr>
                        <tr>
                            <td>No. RM</td>
                            <td>:</td>
                            <td><?= $riwayat['no_rm'] ?></td>
                        </tr>
                        <tr>
                            <td>No. HP</td>
                            <td>:</td>
                            <td><?= $riwayat['no_pasien'] ?></td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <h5 class="border-bottom pb-2">Informasi Pemeriksaan</h5>
                    <table class="table table-borderless">
                        <tr>
                            <td width="30%">Tanggal Periksa</td>
                            <td width="5%">:</td>
                            <td><?= date('d/m/Y', strtotime($riwayat['tgl_periksa'])) ?></td>
                        </tr>
                        <tr>
                            <td>Keluhan</td>
                            <td>:</td>
                            <td><?= $riwayat['keluhan'] ?></td>
                        </tr>
                        <tr>
                            <td>Catatan</td>
                            <td>:</td>
                            <td><?= $riwayat['catatan'] ?></td>
                        </tr>
                        <tr>
                            <td>Biaya Pemeriksaan</td>
                            <td>:</td>
                            <td>Rp <?= number_format($riwayat['biaya_periksa'], 0, ',', '.') ?></td>
                        </tr>
                    </table>
                </div>
            </div>

            <!-- Informasi Obat -->
            <div class="row">
                <div class="col-12">
                    <h5 class="border-bottom pb-2">Obat yang Diberikan</h5>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead class="bg-light">
                                <tr>
                                    <th style="width: 5%">No</th>
                                    <th style="width: 45%">Nama Obat</th>
                                    <th style="width: 25%">Kemasan</th>
                                    <th style="width: 25%">Harga</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(!empty($obatDiberikan)): ?>
                                    <?php 
                                    $no = 1;
                                    $totalBiayaObat = 0;
                                    foreach($obatDiberikan as $obat): 
                                        $totalBiayaObat += $obat['harga'];
                                    ?>
                                        <tr>
                                            <td><?= $no++ ?></td>
                                            <td><?= $obat['nama_obat'] ?></td>
                                            <td><?= $obat['kemasan'] ?></td>
                                            <td>Rp <?= number_format($obat['harga'], 0, ',', '.') ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                    <tr class="bg-light">
                                        <td colspan="3" class="text-end"><strong>Total Biaya Obat:</strong></td>
                                        <td><strong>Rp <?= number_format($totalBiayaObat, 0, ',', '.') ?></strong></td>
                                    </tr>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="4" class="text-center">Tidak ada data obat</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>

                    <?php if(!empty($obatDiberikan)): ?>
                    <div class="card bg-light mt-3">
                        <div class="card-body">
                            <h6 class="card-title">Total Biaya Keseluruhan</h6>
                            <table class="table table-borderless mb-0">
                                <tr>
                                    <td>Biaya Pemeriksaan</td>
                                    <td>:</td>
                                    <td>Rp <?= number_format($riwayat['biaya_periksa'], 0, ',', '.') ?></td>
                                </tr>
                                <tr>
                                    <td>Total Biaya Obat</td>
                                    <td>:</td>
                                    <td>Rp <?= number_format($totalBiayaObat, 0, ',', '.') ?></td>
                                </tr>
                                <tr class="fw-bold">
                                    <td>Total Keseluruhan</td>
                                    <td>:</td>
                                    <td>Rp <?= number_format($riwayat['biaya_periksa'] + $totalBiayaObat, 0, ',', '.') ?></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.table-borderless td {
    padding: 0.5rem 0;
}
.border-bottom {
    border-bottom: 2px solid #dee2e6 !important;
}
.table > :not(caption) > * > * {
    padding: 0.75rem;
}
</style>