<!-- Template row perlu diletakkan di luar form -->
<div id="rowTemplate" style="display:none">
   <table>
       <tr>
           <td>
               <select name="obat[]" class="form-select obat-select">
                   <option value="">Pilih Obat</option>
                   <?php foreach($obatList as $obat): ?>
                       <option value="<?= $obat['obat_id'] ?>" 
                               data-harga="<?= $obat['harga'] ?>"
                               data-kemasan="<?= $obat['kemasan'] ?>">
                           <?= $obat['nama_obat'] ?>
                       </option>
                   <?php endforeach; ?>
               </select>
           </td>
           <td class="kemasan"></td>
           <td class="harga"></td>
           <td>
               <button type="button" class="btn btn-danger btn-sm delete-row">
                   <i class="bi bi-trash"></i> Hapus
               </button>
           </td>
       </tr>
   </table>
</div>

<div class="container my-5">
   <div class="card">
       <div class="card-header bg-primary text-white">
           <h4 class="mb-0"><?= isset($periksa) ? 'Edit' : 'Form' ?> Pemeriksaan Pasien</h4>
       </div>
       <div class="card-body">
           <form action="/dokter/memeriksa/simpan" method="POST" id="pemeriksaanForm">
           <?= csrf_field() ?>
               <input type="hidden" name="id_daftar_poli" value="<?= $daftarPoli['id'] ?>">
               
               <!-- Info Pasien -->
               <div class="card mb-4">
                   <div class="card-header">
                       <h5 class="mb-0">Informasi Pasien</h5>
                   </div>
                   <div class="card-body">
                       <div class="row">
                           <div class="col-md-4">
                               <p><strong>No. RM:</strong><br> <?= $daftarPoli['no_rm'] ?></p>
                           </div>
                           <div class="col-md-4">
                               <p><strong>Nama Pasien:</strong><br> <?= $daftarPoli['nama_pasien'] ?></p>
                           </div>
                           <div class="col-md-4">
                               <p><strong>Keluhan:</strong><br> <?= $daftarPoli['keluhan'] ?></p>
                           </div>
                       </div>
                   </div>
               </div>

               <!-- Catatan Pemeriksaan -->
               <div class="card mb-4">
                   <div class="card-header">
                       <h5 class="mb-0">Catatan Pemeriksaan</h5>
                   </div>
                   <div class="card-body">
                       <textarea name="catatan" class="form-control" rows="4" required 
                           placeholder="Masukkan catatan pemeriksaan..."><?= isset($periksa) ? $periksa['catatan'] : '' ?></textarea>
                   </div>
               </div>

               <!-- Resep Obat -->
               <div class="card mb-4">
                   <div class="card-header">
                       <h5 class="mb-0">Resep Obat</h5>
                   </div>
                   <div class="card-body">
                       <div class="table-responsive">
                           <table class="table table-hover" id="obatTable">
                               <thead>
                                   <tr>
                                       <th width="40%">Nama Obat</th>
                                       <th width="25%">Kemasan</th>
                                       <th width="20%">Harga</th>
                                       <th width="15%">Aksi</th>
                                   </tr>
                               </thead>
                               <tbody>
                                   <!-- Dynamic rows will be added here -->
                               </tbody>
                           </table>
                           <button type="button" class="btn btn-success btn-sm" id="addObat">
                               <i class="bi bi-plus-circle"></i> Tambah Obat
                           </button>
                       </div>
                   </div>
               </div>

               <!-- Biaya -->
               <div class="card mb-4">
                   <div class="card-header">
                       <h5 class="mb-0">Rincian Biaya</h5>
                   </div>
                   <div class="card-body">
                       <div class="row">
                           <div class="col-md-4 mb-3">
                               <label class="form-label">Biaya Jasa</label>
                               <div class="input-group">
                                   <span class="input-group-text">Rp</span>
                                   <input type="number" name="biaya_jasa" id="biayaJasa" class="form-control bg-light" value="150000" readonly>
                               </div>
                           </div>
                           <div class="col-md-4 mb-3">
                               <label class="form-label">Total Biaya Obat</label>
                               <div class="input-group">
                                   <span class="input-group-text">Rp</span>
                                   <input type="number" name="total_obat" id="totalObat" class="form-control" readonly>
                               </div>
                           </div>
                           <div class="col-md-4 mb-3">
                               <label class="form-label">Total Biaya</label>
                               <div class="input-group">
                                   <span class="input-group-text">Rp</span>
                                   <input type="number" id="totalBiaya" class="form-control" readonly>
                               </div>
                           </div>
                       </div>
                   </div>
               </div>

               <div class="text-end">
                   <button type="button" class="btn btn-secondary me-2" onclick="history.back()">
                       <i class="bi bi-arrow-left"></i> Kembali
                   </button>
                   <button type="submit" class="btn btn-primary">
                       <i class="bi bi-save"></i> <?= isset($periksa) ? 'Update' : 'Simpan' ?> Pemeriksaan
                   </button>
               </div>
           </form>
       </div>
   </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
   const addObatBtn = document.getElementById('addObat');
   const obatTable = document.getElementById('obatTable');
   const rowTemplate = document.getElementById('rowTemplate');
   const form = document.getElementById('pemeriksaanForm');
   
   function updateTotalBiaya() {
       const biayaJasa = 150000; // Fixed biaya jasa
       let totalObat = 0;
       
       document.querySelectorAll('.obat-select').forEach(select => {
           if(select.value) {
               const harga = parseInt(select.options[select.selectedIndex].dataset.harga);
               totalObat += harga;
           }
       });
       
       document.getElementById('totalObat').value = totalObat;
       document.getElementById('totalBiaya').value = biayaJasa + totalObat;
   }
   
   function addObatRow(selectedObatId = '', triggerChange = true) {
       const templateContent = rowTemplate.querySelector('tr').cloneNode(true);
       obatTable.querySelector('tbody').appendChild(templateContent);
       
       const select = templateContent.querySelector('.obat-select');
       select.required = true;
       
       if(selectedObatId) {
           select.value = selectedObatId;
       }
       
       select.addEventListener('change', function(e) {
           const option = e.target.options[e.target.selectedIndex];
           const row = e.target.closest('tr');
           if (option.value) {
               row.querySelector('.kemasan').textContent = option.dataset.kemasan;
               row.querySelector('.harga').textContent = `Rp ${parseInt(option.dataset.harga).toLocaleString('id-ID')}`;
           } else {
               row.querySelector('.kemasan').textContent = '';
               row.querySelector('.harga').textContent = '';
           }
           updateTotalBiaya();
       });
       
       templateContent.querySelector('.delete-row').addEventListener('click', function() {
           const tbody = obatTable.querySelector('tbody');
           if (tbody.children.length > 1) {
               templateContent.remove();
               updateTotalBiaya();
           } else {
               alert('Minimal harus ada satu obat');
           }
       });

       if(triggerChange && selectedObatId) {
           select.dispatchEvent(new Event('change'));
       }
   }
   
   // Initialize form for editing if data exists
   <?php if(isset($periksa) && isset($detailObat)): ?>
       <?php foreach($detailObat as $detail): ?>
           addObatRow('<?= $detail['id_obat'] ?>', true);
       <?php endforeach; ?>
   <?php else: ?>
       addObatRow();
   <?php endif; ?>
   
   addObatBtn.addEventListener('click', () => addObatRow());
   
   // Form validation before submit
   form.addEventListener('submit', function(e) {
       e.preventDefault();
       
       // Check if catatan is filled
       const catatan = form.querySelector('textarea[name="catatan"]');
       if (!catatan.value.trim()) {
           alert('Catatan pemeriksaan harus diisi');
           catatan.focus();
           return;
       }
       
       // Check if at least one obat is selected
       const obatSelects = form.querySelectorAll('.obat-select');
       let obatSelected = false;
       obatSelects.forEach(select => {
           if (select.value) obatSelected = true;
       });
       
       if (!obatSelected) {
           alert('Minimal satu obat harus dipilih');
           return;
       }
       
       // If all validations pass, submit the form
       form.submit();
   });
});
</script>

<style>
.bi::before {
   vertical-align: middle;
}
.card-header {
   background-color: #f8f9fa;
}
.form-label {
   font-weight: 500;
}
.input-group-text {
   background-color: #e9ecef;
}
</style>