<div class="container my-5">
   <div class="card">
       <div class="card-header">
           <h3 class="mb-0">Daftar Riwayat Pasien</h3>
       </div>
       <div class="card-body">
           <div class="table-responsive">
               <table class="table table-striped table-hover mb-0">
                   <thead class="bg-primary text-white">
                       <tr>
                           <th width="5%">No</th>
                           <th width="20%">Nama Pasien</th>
                           <th width="25%">Alamat</th>
                           <th width="15%">No. KTP</th>
                           <th width="15%">No. Telepon</th>
                           <th width="10%">No. RM</th>
                           <th width="10%">Aksi</th>
                       </tr>
                   </thead>
                   <tbody>
                       <?php 
                       $uniquePatients = [];
                       foreach($riwayatPeriksa as $riwayat) {
                           $key = $riwayat['no_rm'];
                           if (!isset($uniquePatients[$key])) {
                               $uniquePatients[$key] = $riwayat;
                           }
                       }

                       if(!empty($uniquePatients)): 
                           $no = 1;
                           foreach($uniquePatients as $pasien): 
                       ?>
                           <tr>
                               <td><?= $no++ ?></td>
                               <td><?= $pasien['nama_pasien'] ?></td>
                               <td><?= $pasien['alamat'] ?? '-' ?></td>
                               <td><?= $pasien['no_ktp'] ?? '-' ?></td>
                               <td><?= $pasien['no_hp'] ?></td>
                               <td><?= $pasien['no_rm'] ?></td>
                               <td>
                                   <button type="button" 
                                           class="btn btn-info btn-sm" 
                                           onclick="showRiwayat('<?= $pasien['no_rm'] ?>')">
                                       <i class="bi bi-clock-history"></i>
                                       Detail Riwayat
                                   </button>
                               </td>
                           </tr>
                       <?php 
                           endforeach;
                       else: 
                       ?>
                           <tr>
                               <td colspan="7" class="text-center">Tidak ada data riwayat pasien</td>
                           </tr>
                       <?php endif; ?>
                   </tbody>
               </table>
           </div>
       </div>
   </div>
</div>

<!-- Modal Riwayat -->
<div class="modal fade" id="riwayatModal" tabindex="-1">
   <div class="modal-dialog modal-xl">
       <div class="modal-content">
           <div class="modal-header bg-primary text-white">
               <h5 class="modal-title">Riwayat Pemeriksaan Pasien</h5>
               <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
           </div>
           <div class="modal-body">
               <div class="table-responsive">
                   <table class="table table-striped">
                       <thead>
                           <tr>
                               <th>No</th>
                               <th>Tanggal Periksa</th>
                               <th>Nama Pasien</th>
                               <th>Nama Dokter</th>
                               <th>Keluhan</th>
                               <th>Catatan</th>
                               <th>Obat</th>
                               <th>Biaya Periksa</th>
                           </tr>
                       </thead>
                       <tbody id="riwayatDetail">
                       </tbody>
                   </table>
               </div>
           </div>
           <div class="modal-footer">
               <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
           </div>
       </div>
   </div>
</div>

<style>
.table > :not(caption) > * > * {
   padding: 0.75rem;
}
.btn-sm {
   font-size: 0.875rem;
   padding: 0.25rem 0.5rem;
}
.table-hover tbody tr:hover {
   background-color: rgba(0,0,0,.075);
}
.bg-primary {
   background-color: #0d6efd !important;
}
.card-header {
   background-color: #f8f9fa;
   border-bottom: 1px solid rgba(0,0,0,.125);
}
.modal-xl {
   max-width: 1140px;
}
</style>

<script>
function showRiwayat(noRm) {
   const riwayatList = <?= json_encode($riwayatPeriksa) ?>;
   const filteredRiwayat = riwayatList.filter(r => r.no_rm === noRm);
   
   let html = '';
   filteredRiwayat.forEach((riwayat, index) => {
       html += `
           <tr>
               <td>${index + 1}</td>
               <td>${formatDate(riwayat.tgl_periksa)}</td>
               <td>${riwayat.nama_pasien}</td>
               <td>${riwayat.nama_dokter}</td>
               <td>${riwayat.keluhan}</td>
               <td>${riwayat.catatan}</td>
               <td>${riwayat.obat_list || '-'}</td>
               <td>Rp ${formatNumber(riwayat.biaya_periksa)}</td>
           </tr>
       `;
   });
   
   document.getElementById('riwayatDetail').innerHTML = html;
   new bootstrap.Modal(document.getElementById('riwayatModal')).show();
}

function formatDate(date) {
   return new Date(date).toLocaleDateString('id-ID', {
       year: 'numeric',
       month: '2-digit',
       day: '2-digit',
       hour: '2-digit',
       minute: '2-digit'
   }).replace(',', '');
}

function formatNumber(num) {
   return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}
</script>