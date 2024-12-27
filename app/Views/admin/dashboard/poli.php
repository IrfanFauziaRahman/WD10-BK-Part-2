<div class="container mt-1">
    <!-- Heading -->
    <div class="text-center mb-3">
        <h2 class="fw-bold text-primary">
            <i class="fas fa-hospital"></i>
            <?= isset($poliData) ? 'Edit Poli' : 'Poli'; ?>
        </h2>
        <p class="text-muted">Kelola data poli untuk kebutuhan sistem.</p>
    </div>

    <!-- Alert Notification -->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            setTimeout(function () {
                const alerts = document.querySelectorAll(".alert");
                alerts.forEach(alert => alert.style.display = "none");
            }, 5000); // 5 detik
        });
    </script>

    <!-- Flash Messages -->
    <?php if (session()->getFlashdata('error')) : ?>
        <div class="alert alert-danger alert-dismissible fade show">
            <?= session()->getFlashdata('error') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('success')) : ?>
        <div class="alert alert-success alert-dismissible fade show">
            <?= session()->getFlashdata('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <!-- Form Card -->
    <div class="card shadow mb-4">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0"><?= isset($poliData) ? 'Edit Data Poli' : 'Tambah Data Poli'; ?></h5>
        </div>
        <div class="card-body">
            <form action="<?= isset($poliData) ? '/admin/poli/update/' . $poliData['poli_id'] : '/admin/poli/save'; ?>" method="post">
                <!-- CSRF Token -->
                <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>">

                <div class="mb-3">
                    <label for="nama_poli" class="form-label">Nama Poli</label>
                    <input type="text" id="nama_poli" name="nama_poli" class="form-control" placeholder="Nama Poli" 
                           value="<?= isset($poliData) ? $poliData['nama_poli'] : ''; ?>" required>
                </div>
                
                <div class="mb-3">
                    <label for="keterangan" class="form-label">Keterangan</label>
                    <input type="text" id="keterangan" name="keterangan" class="form-control" placeholder="Keterangan" 
                           value="<?= isset($poliData) ? $poliData['keterangan'] : ''; ?>" required>
                </div>
                
                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary me-2 mr-2"><?= isset($poliData) ? 'Update' : 'Simpan'; ?></button>
                    <?php if (isset($poliData)): ?>
                        <a href="/admin/poli" class="btn btn-secondary">Batal</a>
                    <?php endif; ?>
                </div>
            </form>
        </div>
    </div>

    <!-- Table Card -->
    <div class="card shadow">
        <div class="card-header bg-success text-white">
            <h5 class="mb-0"><i class="fas fa-table"></i> Data Poli</h5>
        </div>
        <div class="card-body">
            <table class="table table-hover table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th>Nama Poli</th>
                        <th>Keterangan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($poli) && count($poli) > 0): ?>
                        <?php foreach ($poli as $index => $row): ?>
                            <tr>
                                <td><?= $index + 1 ?></td>
                                <td><?= $row['nama_poli'] ?></td>
                                <td><?= $row['keterangan'] ?></td>
                                <td>
                                    <a href="/admin/poli/edit/<?= $row['poli_id'] ?>" class="btn btn-success btn-sm">Edit</a>
                                    <a href="/admin/poli/delete/<?= $row['poli_id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?');">Hapus</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4" class="text-center text-muted">Tidak ada data</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
/* Styling untuk header tabel */
.table-dark {
    background-color: #212529 !important;
}

/* Mencegah perubahan warna saat hover pada header tabel */
.table-hover tbody tr:hover {
    background-color: rgba(0,0,0,.075);
}

/* Header tabel tidak akan berubah saat hover */
.table thead.table-dark tr:hover {
    background-color: #212529 !important;
}

.table thead.table-dark th {
    background-color: #212529 !important;
}

/* Memastikan hover hanya bekerja pada tbody */
.table-hover>tbody>tr:hover>* {
    background-color: rgba(0,0,0,.075);
}

.table-hover>thead>tr:hover>* {
    background-color: inherit !important;
}
</style>