<!-- app/Views/dokter/dashboard/detail_periksa.php -->
<div class="container my-5">
    <div class="card">
        <div class="card-header">
            <h3 class="mb-0">Detail Pemeriksaan Pasien</h3>
        </div>
        <div class="card-body">
            <div class="row mb-4">
                <div class="col-md-6">
                    <h5 class="mb-3">Informasi Pasien</h5>
                    <table class="table table-borderless">
                        <tr>
                            <td style="width: 35%">Nama Pasien</td>
                            <td>: <?= $daftarPoli['nama_pasien'] ?></td>
                        </tr>
                        <tr>
                            <td>No. Rekam Medis</td>
                            <td>: <?= $daftarPoli['no_rm'] ?></td>
                        </tr>
                        <tr>
                            <td>No. Antrian</td>
                            <td>: <?= $daftarPoli['no_antrian'] ?></td>
                        </tr>
                        <tr>
                            <td>Keluhan</td>
                            <td>: <?= $daftarPoli['keluhan'] ?></td>
                        </tr>
                        <tr>
                            <td>Waktu Pendaftaran</td>
                            <td>: <?= date('d/m/Y H:i', strtotime($daftarPoli['created_at'])) ?></td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <h5 class="mb-3">Hasil Pemeriksaan</h5>
                    <table class="table table-borderless">
                        <tr>
                            <td style="width: 35%">Tanggal Periksa</td>
                            <td>: <?= date('d/m/Y', strtotime($periksa['tgl_periksa'])) ?></td>
                        </tr>
                        <tr>
                            <td>Catatan</td>
                            <td>: <?= $periksa['catatan'] ?></td>
                        </tr>
                        <tr>
                            <td>Biaya Pemeriksaan</td>
                            <td>: Rp <?= number_format($periksa['biaya_periksa'], 0, ',', '.') ?></td>
                        </tr>
                    </table>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <h5 class="mb-3">Obat yang Diberikan</h5>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Obat</th>
                                    <th>Kemasan</th>
                                    <th>Harga</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $db = \Config\Database::connect();
                                $query = $db->table('detail_periksa')
                                    ->select('obat.*')
                                    ->join('obat', 'obat.obat_id = detail_periksa.id_obat')
                                    ->where('detail_periksa.id_periksa', $periksa['id'])
                                    ->get();
                                $obatList = $query->getResultArray();
                                
                                if (!empty($obatList)):
                                    $no = 1;
                                    foreach ($obatList as $obat):
                                ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td><?= $obat['nama_obat'] ?></td>
                                        <td><?= $obat['kemasan'] ?></td>
                                        <td>Rp <?= number_format($obat['harga'], 0, ',', '.') ?></td>
                                    </tr>
                                <?php 
                                    endforeach;
                                else:
                                ?>
                                    <tr>
                                        <td colspan="4" class="text-center">Tidak ada data obat</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="mt-4">
                <a href="/dokter/memeriksa" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-2 mr-2"></i>Kembali
                </a>
            </div>
        </div>
    </div>
</div>