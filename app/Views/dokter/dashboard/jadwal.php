<div class="container my-5">
   <div class="card shadow-sm">
       <div class="card-header">
           <div class="d-flex justify-content-between align-items-center">
               <h3 class="mb-0">Jadwal Periksa</h3>
               <button type="button" class="btn btn-primary" onclick="showModal('addJadwalModal')">
                   <i class="bi bi-plus-circle me-3 mr-1"></i>Tambah Jadwal
               </button>
           </div>
       </div>
       <div class="card-body">
           <?php if (session()->getFlashdata('success')): ?>
               <div class="alert alert-success alert-dismissible fade show" role="alert">
                   <?= session()->getFlashdata('success') ?>
                   <button type="button" class="close-btn" onclick="this.parentElement.remove()">×</button>
               </div>
           <?php endif; ?>

           <?php if (session()->getFlashdata('error')): ?>
               <div class="alert alert-danger alert-dismissible fade show" role="alert">
                   <?= session()->getFlashdata('error') ?>
                   <button type="button" class="close-btn" onclick="this.parentElement.remove()">×</button>
               </div>
           <?php endif; ?>

           <?php if (session()->getFlashdata('errors')): ?>
               <div class="alert alert-danger alert-dismissible fade show" role="alert">
                   <?php foreach (session()->getFlashdata('errors') as $error): ?>
                       <p class="mb-0"><?= $error ?></p>
                   <?php endforeach; ?>
                   <button type="button" class="close-btn" onclick="this.parentElement.remove()">×</button>
               </div>
           <?php endif; ?>

           <div class="table-responsive">
               <table class="table table-striped table-hover mb-0">
                   <thead class="bg-primary text-white">
                       <tr>
                           <th style="width: 5%;">No</th>
                           <th style="width: 20%;">Nama Dokter</th>
                           <th style="width: 15%;">Poli</th>
                           <th style="width: 10%;">Hari</th>
                           <th style="width: 15%;">Jam Mulai</th>
                           <th style="width: 15%;">Jam Selesai</th>
                           <th style="width: 10%;" class="text-center">Status</th>
                           <th style="width: 10%;" class="text-center">Aksi</th>
                       </tr>
                   </thead>
                   <tbody>
                       <?php if (isset($jadwalPeriksa) && count($jadwalPeriksa) > 0): ?>
                           <?php foreach ($jadwalPeriksa as $index => $jadwal): ?>
                               <tr>
                                   <td class="align-middle text-center"><?= $index + 1 ?></td>
                                   <td class="align-middle"><?= esc($jadwal['nama_dokter']) ?></td>
                                   <td class="align-middle"><?= esc($jadwal['nama_poli']) ?></td>
                                   <td class="align-middle"><?= esc($jadwal['hari']) ?></td>
                                   <td class="align-middle"><?= date('H:i', strtotime($jadwal['jam_mulai'])) ?></td>
                                   <td class="align-middle"><?= date('H:i', strtotime($jadwal['jam_selesai'])) ?></td>
                                   <td class="align-middle text-center">
                                       <span class="badge <?= $jadwal['status'] == 'Aktif' ? 'bg-success' : 'bg-secondary' ?> status-badge">
                                           <?= $jadwal['status'] ?>
                                       </span>
                                   </td>
                                   <td class="align-middle text-center">
                                       <button class="btn btn-primary btn-sm py-1 px-2" 
                                               onclick="showModal('editJadwalModal<?= $jadwal['id'] ?>')">
                                           <i class="bi bi-pencil-fill me-1"></i>Edit
                                       </button>
                                   </td>
                               </tr>
                           <?php endforeach; ?>
                       <?php else: ?>
                           <tr>
                               <td colspan="8" class="text-center py-4">Tidak ada data jadwal</td>
                           </tr>
                       <?php endif; ?>
                   </tbody>
               </table>
           </div>
       </div>
   </div>
</div>

<!-- Modal Add -->
<div class="modal fade" id="addJadwalModal" tabindex="-1" aria-labelledby="addJadwalModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered">
       <div class="modal-content border-0 shadow">
           <div class="modal-header bg-primary text-white py-3">
               <h5 class="modal-title fw-bold" id="addJadwalModalLabel">
                   <i class="bi bi-calendar-plus me-2 mr-1"></i>Tambah Jadwal Periksa
               </h5>
               <button type="button" class="btn-close-modal" onclick="closeModal('addJadwalModal')">×</button>
           </div>
           <form action="<?= base_url('dokter/jadwal/create') ?>" method="POST" id="addJadwalForm">
               <div class="modal-body p-4">
                   <?= csrf_field() ?>
                   <input type="hidden" name="id_dokter" value="<?= $doctors[0]['dokter_id'] ?>">
                   
                   <div class="mb-3">
                       <label for="hari" class="form-label fw-semibold">Hari</label>
                       <div class="input-group">
                           <span class="input-group-text bg-light">
                               <i class="bi bi-calendar-day me-2"></i>
                           </span>
                           <select class="form-select" name="hari" required>
                               <option value="">Pilih Hari</option>
                               <?php foreach (['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'] as $h): ?>
                                   <option value="<?= $h ?>"><?= $h ?></option>
                               <?php endforeach; ?>
                           </select>
                       </div>
                   </div>
                   
                   <div class="row mb-3">
                       <div class="col-md-6">
                           <label for="jam_mulai" class="form-label fw-semibold">Jam Mulai</label>
                           <div class="input-group">
                               <span class="input-group-text bg-light">
                                   <i class="bi bi-clock me-2"></i>
                               </span>
                               <input type="time" class="form-control" name="jam_mulai" required>
                           </div>
                       </div>
                       <div class="col-md-6">
                           <label for="jam_selesai" class="form-label fw-semibold">Jam Selesai</label>
                           <div class="input-group">
                               <span class="input-group-text bg-light">
                                   <i class="bi bi-clock-fill me-2"></i>
                               </span>
                               <input type="time" class="form-control" name="jam_selesai" required>
                           </div>
                       </div>
                   </div>

                   <div class="mb-3">
                       <label for="status" class="form-label fw-semibold">Status</label>
                       <div class="input-group">
                           <span class="input-group-text bg-light">
                               <i class="bi bi-toggle-on me-2"></i>
                           </span>
                           <select class="form-select" name="status" required>
                               <option value="Aktif">Aktif</option>
                               <option value="Tidak Aktif">Tidak Aktif</option>
                           </select>
                       </div>
                   </div>
               </div>
               <div class="modal-footer bg-light py-3">
                   <button type="button" class="btn btn-secondary" onclick="closeModal('addJadwalModal')">
                       <i class="bi bi-x-circle me-2"></i>Tutup
                   </button>
                   <button type="submit" class="btn btn-primary">
                       <i class="bi bi-save me-2"></i>Simpan
                   </button>
               </div>
           </form>
       </div>
   </div>
</div>

<!-- Modal Edit -->
<?php if (isset($jadwalPeriksa)): ?>
<?php foreach ($jadwalPeriksa as $jadwal): ?>
<div class="modal fade" id="editJadwalModal<?= $jadwal['id'] ?>" tabindex="-1" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered">
       <div class="modal-content border-0 shadow">
           <div class="modal-header bg-primary text-white py-3">
               <h5 class="modal-title fw-bold">
                   <i class="bi bi-pencil-square me-2"></i>Edit Status Jadwal
               </h5>
               <button type="button" class="btn-close-modal" onclick="closeModal('editJadwalModal<?= $jadwal['id'] ?>')">×</button>
           </div>
           <form action="<?= base_url('dokter/jadwal/update/' . $jadwal['id']) ?>" method="POST">
               <div class="modal-body p-4">
                   <?= csrf_field() ?>
                   <input type="hidden" name="id_dokter" value="<?= $doctors[0]['dokter_id'] ?>">
                   
                   <div class="mb-3">
                       <label class="form-label text-muted">Hari</label>
                       <div class="form-control bg-light"><?= $jadwal['hari'] ?></div>
                   </div>
                   
                   <div class="mb-3">
                       <label class="form-label text-muted">Jam Praktik</label>
                       <div class="form-control bg-light">
                           <?= date('H:i', strtotime($jadwal['jam_mulai'])) ?> - 
                           <?= date('H:i', strtotime($jadwal['jam_selesai'])) ?>
                       </div>
                   </div>

                   <div class="mb-3">
                       <label for="status" class="form-label fw-semibold">Status</label>
                       <div class="input-group">
                           <span class="input-group-text bg-light">
                               <i class="bi bi-toggle-on me-2"></i>
                           </span>
                           <select class="form-select" name="status" required>
                               <option value="Aktif" <?= $jadwal['status'] == 'Aktif' ? 'selected' : '' ?>>Aktif</option>
                               <option value="Tidak Aktif" <?= $jadwal['status'] == 'Tidak Aktif' ? 'selected' : '' ?>>Tidak Aktif</option>
                           </select>
                       </div>
                   </div>
               </div>
               <div class="modal-footer bg-light py-3">
                   <button type="button" class="btn btn-secondary" onclick="closeModal('editJadwalModal<?= $jadwal['id'] ?>')">
                       <i class="bi bi-x-circle me-2"></i>Tutup
                   </button>
                   <button type="submit" class="btn btn-primary">
                       <i class="bi bi-save me-2"></i>Simpan
                   </button>
               </div>
           </form>
       </div>
   </div>
</div>
<?php endforeach; ?>
<?php endif; ?>

<style>
.modal-content { border-radius: 10px; }
.modal-header { border-top-left-radius: 10px; border-top-right-radius: 10px; }
.form-control:focus, .form-select:focus {
   border-color: #86b7fe;
   box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
}
.input-group-text { border: 1px solid #ced4da; }
.form-label { color: #444; margin-bottom: 0.5rem; }
.btn {
   padding: 0.5rem 1.5rem;
   font-weight: 500;
   border-radius: 5px;
}
.btn-sm {
   font-size: 0.9rem;
   padding: 0.15rem 0.5rem;
   line-height: 1.2;
}
.btn-sm i {
   font-size: 0.8rem;
}
.status-badge {
   font-size: 0.875rem;
   padding: 0.35rem 0.75rem;
   font-weight: 500;
}
.table > :not(caption) > * > * {
   padding: 1rem 0.75rem;
   vertical-align: middle;
}
.alert {
   border-radius: 8px;
   margin-bottom: 1rem;
   padding: 0.75rem 1.25rem;
}
.btn-close-modal {
   background: none;
   border: none;
   color: white;
   font-size: 28px;
   font-weight: bold;
   opacity: 0.8;
   padding: 0;
   cursor: pointer;
}
.btn-close-modal:hover { opacity: 1; }
.close-btn {
   background: none;
   border: none;
   font-size: 24px;
   font-weight: bold;
   opacity: 0.5;
   cursor: pointer;
}
.close-btn:hover { opacity: 0.75; }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
   window.showModal = function(modalId) {
       const modal = document.getElementById(modalId);
       if (modal) {
           const modalInstance = new bootstrap.Modal(modal);
           modalInstance.show();
       }
   }

   window.closeModal = function(modalId) {
       const modal = document.getElementById(modalId);
       if (modal) {
           const modalInstance = bootstrap.Modal.getInstance(modal);
           if (modalInstance) {
               modalInstance.hide();
           }
       }
   }

   setTimeout(function() {
       document.querySelectorAll('.alert').forEach(function(alert) {
           alert.remove();
       });
   }, 3000);
});
</script>