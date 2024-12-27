<div class="content mt-3">
    <div class="container-fluid">
        <div class="row">
            <!-- Form Daftar Poli -->
            <div class="col-md-4">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-clipboard-list mr-2"></i> Form Pendaftaran</h3>
                    </div>
                    <div class="card-body">
                        <form action="<?= base_url('pasien/poli/daftar') ?>" method="post">
                            <?= csrf_field() ?>
                            <!-- No RM Form Group -->
                            <div class="form-group">
                                <label for="no_rm">Nomor Rekam Medis</label>
                                <input type="text" class="form-control" id="no_rm" name="no_rm" value="<?= $no_rm ?>" readonly>
                            </div>
                            
                            <!-- Poli Form Group -->
                            <div class="form-group">
                                <label for="poli">Pilih Poli</label>
                                <select id="poli" name="poli" class="form-control select2" required>
                                    <option value="" selected disabled>Pilih Poli</option>
                                    <?php foreach($polis as $poli): ?>
                                        <option value="<?= $poli['poli_id'] ?>"><?= $poli['nama_poli'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <!-- Jadwal Form Group -->
                            <div class="form-group">
                                <label for="jadwal">Pilih Jadwal</label>
                                <select id="jadwal" name="jadwal" class="form-control select2" required>
                                    <option value="" selected disabled>Pilih Jadwal</option>
                                </select>
                            </div>

                            <!-- Keluhan Form Group -->
                            <div class="form-group">
                                <label for="keluhan">Keluhan</label>
                                <textarea id="keluhan" name="keluhan" class="form-control" rows="4" required placeholder="Deskripsikan keluhan Anda..."></textarea>
                            </div>

                            <button type="submit" class="btn btn-primary btn-block">
                                <i class="fas fa-check-circle mr-2"></i>Daftar
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Riwayat Daftar Poli -->
            <div class="col-md-8">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-history mr-2"></i> Riwayat Pendaftaran Poli</h3>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th class="text-center" width="5%">No.</th>
                                        <th>Poli</th>
                                        <th>Dokter</th>
                                        <th>Hari</th>
                                        <th>Jam</th>
                                        <th class="text-center">Antrian</th>
                                        <th class="text-center">Status</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if(empty($riwayat)): ?>
                                        <tr>
                                            <td colspan="8" class="text-center text-muted">
                                                <i class="fas fa-info-circle mr-2"></i>Belum ada riwayat pendaftaran
                                            </td>
                                        </tr>
                                    <?php else: ?>
                                        <?php foreach($riwayat as $index => $row): ?>
                                            <tr>
                                                <td class="text-center"><?= $index + 1 ?></td>
                                                <td><?= $row['nama_poli'] ?></td>
                                                <td><?= $row['nama_dokter'] ?></td>
                                                <td><?= $row['hari'] ?></td>
                                                <td><?= date('H:i', strtotime($row['jam_mulai'])) ?> - <?= date('H:i', strtotime($row['jam_selesai'])) ?></td>
                                                <td class="text-center">
                                                    <span class="badge badge-primary"><?= $row['no_antrian'] ?></span>
                                                </td>
                                                <td class="text-center">
                                                    <?php
                                                    $statusClass = match($row['status']) {
                                                        'menunggu' => 'badge-warning',
                                                        'diperiksa' => 'badge-info',
                                                        'selesai' => 'badge-success',
                                                        default => 'badge-secondary'
                                                    };
                                                    ?>
                                                    <span class="badge <?= $statusClass ?>">
                                                        <?= ucfirst($row['status']) ?>
                                                    </span>
                                                </td>
                                                <td class="text-center">
                                                    <?php if($row['status'] == 'selesai'): ?>
                                                        <button type="button" 
                                                                class="btn btn-success btn-sm" 
                                                                data-toggle="modal" 
                                                                data-target="#detailModal<?= $row['id'] ?>">
                                                            <i class="fas fa-history"></i> Riwayat
                                                        </button>
                                                    <?php else: ?>
                                                        <button type="button" 
                                                                class="btn btn-info btn-sm" 
                                                                data-toggle="modal" 
                                                                data-target="#detailModal<?= $row['id'] ?>">
                                                            <i class="fas fa-eye"></i> Detail
                                                        </button>
                                                    <?php endif; ?>
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
        </div>
    </div>
</div>

<!-- Modals -->
<?php foreach($riwayat as $index => $row): ?>
    <?php if($row['status'] == 'selesai'): ?>
        <!-- Modal Riwayat -->
        <div class="modal fade" id="detailModal<?= $row['id'] ?>">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Detail Riwayat Periksa</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="card-title">Informasi Pasien</h3>
                                    </div>
                                    <div class="card-body p-0">
                                        <table class="table">
                                            <tr>
                                                <td width="30%">Nama Pasien</td>
                                                <td width="5%">:</td>
                                                <td><?= $row['nama_pasien'] ?></td>
                                            </tr>
                                            <tr>
                                                <td>No. RM</td>
                                                <td>:</td>
                                                <td><?= $row['no_rm'] ?></td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="card-title">Informasi Pemeriksaan</h3>
                                    </div>
                                    <div class="card-body p-0">
                                        <?php 
                                            $db = \Config\Database::connect();
                                            $periksa = $db->table('periksa')
                                                ->where('id_daftar_poli', $row['id'])
                                                ->get()
                                                ->getRowArray();
                                        ?>
                                        <table class="table">
                                            <tr>
                                                <td width="30%">Tanggal Periksa</td>
                                                <td width="5%">:</td>
                                                <td><?= date('d/m/Y', strtotime($periksa['tgl_periksa'])) ?></td>
                                            </tr>
                                            <tr>
                                                <td>Keluhan</td>
                                                <td>:</td>
                                                <td><?= $row['keluhan'] ?></td>
                                            </tr>
                                            <tr>
                                                <td>Catatan</td>
                                                <td>:</td>
                                                <td><?= $periksa['catatan'] ?></td>
                                            </tr>
                                            <tr>
                                                <td>Biaya Pemeriksaan</td>
                                                <td>:</td>
                                                <td>Rp <?= number_format($periksa['biaya_periksa'], 0, ',', '.') ?></td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Informasi Obat -->
                        <div class="card mt-3">
                            <div class="card-header">
                                <h3 class="card-title">Obat yang Diberikan</h3>
                            </div>
                            <div class="card-body p-0">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th style="width: 5%">No</th>
                                            <th>Nama Obat</th>
                                            <th>Kemasan</th>
                                            <th>Harga</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                            $obatList = $db->table('detail_periksa')
                                                ->select('obat.*')
                                                ->join('obat', 'obat.obat_id = detail_periksa.id_obat')
                                                ->where('detail_periksa.id_periksa', $periksa['id'])
                                                ->get()
                                                ->getResultArray();
                                            
                                            if(!empty($obatList)):
                                                $no = 1;
                                                $totalBiayaObat = 0;
                                                foreach($obatList as $obat):
                                                    $totalBiayaObat += $obat['harga'];
                                        ?>
                                            <tr>
                                                <td><?= $no++ ?></td>
                                                <td><?= $obat['nama_obat'] ?></td>
                                                <td><?= $obat['kemasan'] ?></td>
                                                <td>Rp <?= number_format($obat['harga'], 0, ',', '.') ?></td>
                                            </tr>
                                        <?php 
                                                endforeach;
                                        ?>
                                            <tr>
                                                <td colspan="3" class="text-right"><strong>Total Biaya Obat:</strong></td>
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
                        </div>

                        <?php if(!empty($obatList)): ?>
                        <div class="card mt-3 bg-light">
                            <div class="card-body">
                                <h5 class="card-title">Total Biaya Keseluruhan</h5>
                                <table class="table table-sm">
                                    <tr>
                                        <td>Biaya Pemeriksaan</td>
                                        <td>:</td>
                                        <td>Rp <?= number_format($periksa['biaya_periksa'], 0, ',', '.') ?></td>
                                    </tr>
                                    <tr>
                                        <td>Total Biaya Obat</td>
                                        <td>:</td>
                                        <td>Rp <?= number_format($totalBiayaObat, 0, ',', '.') ?></td>
                                    </tr>
                                    <tr class="font-weight-bold">
                                        <td>Total Keseluruhan</td>
                                        <td>:</td>
                                        <td>Rp <?= number_format($periksa['biaya_periksa'] + $totalBiayaObat, 0, ',', '.') ?></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
    <?php else: ?>
        <!-- Modal Detail -->
        <div class="modal fade" id="detailModal<?= $row['id'] ?>">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Detail Pemeriksaan Pasien</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <table class="table table-bordered">
                            <tr>
                                <th style="width: 35%">Nama Pasien</th>
                                <td><?= $row['nama_pasien'] ?></td>
                            </tr>
                            <tr>
                               <th>No. Rekam Medis</th>
                               <td><?= $row['no_rm'] ?></td>
                           </tr>
                           <tr>
                               <th>No. Antrian</th>
                               <td><?= $row['no_antrian'] ?></td>
                           </tr>
                           <tr>
                               <th>Keluhan</th>
                               <td><?= $row['keluhan'] ?></td>
                           </tr>
                           <tr>
                               <th>Poli</th>
                               <td><?= $row['nama_poli'] ?></td>
                           </tr>
                           <tr>
                               <th>Dokter</th>
                               <td><?= $row['nama_dokter'] ?></td>
                           </tr>
                           <tr>
                               <th>Jadwal</th>
                               <td><?= $row['hari'] ?>, <?= date('H:i', strtotime($row['jam_mulai'])) ?> - <?= date('H:i', strtotime($row['jam_selesai'])) ?></td>
                           </tr>
                           <tr>
                               <th>Status</th>
                               <td><span class="badge <?= $statusClass ?>"><?= ucfirst($row['status']) ?></span></td>
                           </tr>
                           <tr>
                               <th>Waktu Pendaftaran</th>
                               <td><?= date('d/m/Y H:i', strtotime($row['created_at'])) ?></td>
                           </tr>
                       </table>
                   </div>
                   <div class="modal-footer">
                       <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                   </div>
               </div>
           </div>
       </div>
   <?php endif; ?>
<?php endforeach; ?>

<!-- Tambahkan script ini di bagian bawah file daftarPoli.php -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Inisialisasi Select2
    $('.select2bs4').select2({
        theme: 'bootstrap4'
    });
    
    $('#poli').on('change', function() {
        var poliId = $(this).val();
        console.log('Selected Poli ID:', poliId);
        
        if(poliId) {
            // Tampilkan loading di dropdown jadwal
            $('#jadwal').html('<option value="">Loading...</option>');
            
            $.ajax({
                url: '<?= base_url('pasien/poli/getJadwal') ?>',
                method: 'POST',
                data: {
                    poli_id: poliId,
                    <?= csrf_token() ?>: '<?= csrf_hash() ?>'
                },
                dataType: 'json',
                success: function(response) {
                    console.log('Server Response:', response);
                    
                    var options = '<option value="">Pilih Jadwal</option>';
                    
                    if(response && response.length > 0) {
                        response.forEach(function(jadwal) {
                            options += '<option value="' + jadwal.id + '">' +
                                     jadwal.hari + ', ' +
                                     jadwal.jam_mulai.substring(0,5) + ' - ' +
                                     jadwal.jam_selesai.substring(0,5) + ' (' +
                                     jadwal.nama_dokter + ')</option>';
                        });
                    } else {
                        options = '<option value="">Tidak ada jadwal tersedia</option>';
                    }
                    
                    $('#jadwal').html(options);
                },
                error: function(xhr, status, error) {
                    console.error('Ajax Error:', {xhr: xhr, status: status, error: error});
                    $('#jadwal').html('<option value="">Error mengambil jadwal</option>');
                }
            });
        } else {
            $('#jadwal').html('<option value="">Pilih Jadwal</option>');
        }
    });
});
</script>