<!-- app/Views/dokter/dashboard/memeriksa.php -->
<div class="container my-5">
  <div class="card shadow-sm">
    <div class="card-header">
      <h3 class="mb-0">Daftar Periksa Pasien</h3>
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

      <div class="table-responsive">
        <table class="table table-striped table-hover mb-0">
          <thead class="bg-primary text-white">
            <tr>
              <th style="width: 8%;">NO. ANTRIAN</th>
              <th style="width: 15%;">PASIEN</th>
              <th style="width: 20%;">NO. RM</th>
              <th style="width: 20%;">KELUHAN</th>
              <th style="width: 15%;">WAKTU DAFTAR</th>
              <th style="width: 10%;" class="text-center">STATUS</th>
              <th style="width: 12%;" class="text-center">AKSI</th>
            </tr>
          </thead>
          <tbody>
            <?php if(!empty($daftarPoli)): ?>
                <?php foreach($daftarPoli as $daftar): ?>
                    <tr>
                        <td class="align-middle"><?= $daftar['no_antrian'] ?></td>
                        <td class="align-middle"><?= $daftar['nama_pasien'] ?></td>
                        <td class="align-middle"><?= $daftar['no_rm'] ?></td>
                        <td class="align-middle"><?= $daftar['keluhan'] ?></td>
                        <td class="align-middle"><?= date('d/m/Y H:i', strtotime($daftar['created_at'])) ?></td>
                        <td class="align-middle text-center">
                            <span class="badge status-badge bg-<?= $daftar['status'] === 'selesai' ? 'success' : 
                                ($daftar['status'] === 'diperiksa' ? 'warning' : 'secondary') ?>">
                                <?= ucfirst($daftar['status']) ?>
                            </span>
                        </td>
                        <td class="align-middle text-center">
                            <?php if($daftar['status'] === 'menunggu'): ?>
                                <a href="/dokter/memeriksa/mulai/<?= $daftar['id'] ?>" class="btn btn-warning btn-sm d-inline-flex align-items-center">
                                    <i class="bi bi-stethoscope"></i>
                                    <span class="ms-2">Mulai Periksa</span>
                                </a>
                            <?php elseif($daftar['status'] === 'diperiksa'): ?>
                                <a href="/dokter/memeriksa/lanjutkan/<?= $daftar['id'] ?>" class="btn btn-info btn-sm d-inline-flex align-items-center">
                                    <i class="bi bi-arrow-right-circle"></i>
                                    <span class="ms-2">Lanjutkan</span>
                                </a>
                            <!-- Modifikasi bagian tombol detail -->
                            <?php else: ?>
                              <a href="/dokter/memeriksa/edit/<?= $daftar['id'] ?>" class="btn btn-warning btn-sm d-inline-flex align-items-center action-btn">
                                 <i class="bi bi-pencil-square mr-2"></i>
                                 <span class="ms-2">Edit</span>
                              </a>
                           <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7" class="text-center">Tidak ada data pasien</td>
                </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<!-- Bootstrap Icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

<style>
/* Card Styling */
.card {
   border: none;
   margin-bottom: 1.5rem;
}

.card.shadow-sm {
   box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
}

.card-header {
   background-color: #fff;
   border-bottom: 1px solid rgba(0,0,0,.125);
   padding: 1rem 1.25rem;
}

.card-body {
   padding: 1.25rem;
}

/* Table Styling */
.table > :not(caption) > * > * {
   padding: 1rem 0.75rem;
   vertical-align: middle;
}

.table-responsive {
   overflow-x: auto;
   -webkit-overflow-scrolling: touch;
}

/* Status Badge */
.status-badge {
   font-size: 0.875rem;
   padding: 0.35rem 0.75rem;
   font-weight: 500;
   letter-spacing: 0.3px;
}

/* Button Actions */
.btn-sm {
   padding: 0.25rem 0.5rem;  
   font-size: 0.875rem;
   display: inline-flex;
   align-items: center;
   gap: 0.25rem;  
}

.btn-sm i {
   font-size: 0.875rem;  
}

.action-btn {
   min-width: auto;  
   white-space: nowrap;
}

.btn i {
   font-size: 1rem;
}

/* Alert Styling */
.alert {
   border-radius: 8px;
   margin-bottom: 1rem;
   padding: 0.75rem 1.25rem;
   display: flex;
   align-items: center;
   justify-content: space-between;
}

/* Close Button */
.close-btn {
   background: none;
   border: none;
   color: inherit;
   font-size: 28px;
   font-weight: bold;
   opacity: 0.8;
   padding: 0;
   margin-left: 15px;
   cursor: pointer;
   line-height: 1;
   transition: opacity 0.2s ease-in-out;
}

.close-btn:hover {
   opacity: 1;
}

.close-btn:focus {
   outline: none;
}

/* Modal Close Button (X) */
.btn-close-modal {
   background: none;
   border: none;
   color: white;
   font-size: 28px;
   font-weight: bold;
   opacity: 0.8;
   padding: 0;
   cursor: pointer;
   line-height: 1;
   transition: opacity 0.2s ease-in-out;
}

.btn-close-modal:hover {
   opacity: 1;
}

.btn-close-modal:focus {
   outline: none;
}

/* Form Elements */
.form-control:focus, 
.form-select:focus {
   border-color: #86b7fe;
   box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
}

.input-group-text {
   border: 1px solid #ced4da;
}

.form-label {
   color: #444;
   margin-bottom: 0.5rem;
}

/* Modal Styling */
.modal-content {
   border-radius: 10px;
}

.modal-header {
   border-top-left-radius: 10px;
   border-top-right-radius: 10px;
}

.modal-title i {
   font-size: 1.2rem;
}

/* Input Group Styling */
.input-group {
   position: relative;
}

.input-group-text {
   background-color: #f8f9fa;
}

.input-group-text i {
   font-size: 1.1rem;
   width: 1.5rem;
   text-align: center;
}

/* Form Validation */
.was-validated .form-control:valid,
.form-control.is-valid {
   border-color: #198754;
   padding-right: calc(1.5em + 0.75rem);
}

.was-validated .form-control:invalid,
.form-control.is-invalid {
   border-color: #dc3545;
   padding-right: calc(1.5em + 0.75rem);
}

/* Utility Classes */
.gap-2 {
   gap: 0.5rem !important;
}

.w-auto {
   width: auto !important;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto close alert after 3 seconds
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        setTimeout(() => {
            alert.remove();
        }, 3000);
    });
});
</script>