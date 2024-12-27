<div class="container mt-1">
    <!-- Heading -->
    <div class="text-center mb-3">
        <h2 class="fw-bold text-primary">
            <i class="fas fa-pills"></i>
            <?= isset($obatData) ? 'Edit Obat' : 'Obat'; ?>
        </h2>
        <p class="text-muted">Gunakan form di bawah ini untuk menambahkan atau mengedit data obat.</p>
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
            <h5 class="mb-0"><?= isset($obatData) ? 'Edit Data Obat' : 'Tambah Data Obat'; ?></h5>
        </div>
        <div class="card-body">
            <form action="<?= isset($obatData) ? '/admin/obat/update/' . $obatData['obat_id'] : '/admin/obat/save'; ?>" method="post">
                <!-- CSRF Token -->
                <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>">

                <div class="mb-3">
                    <label for="nama_obat" class="form-label">Nama Obat</label>
                    <input type="text" id="nama_obat" name="nama_obat" class="form-control" placeholder="Nama Obat"
                           value="<?= isset($obatData) ? $obatData['nama_obat'] : ''; ?>" required>
                </div>
                
                <div class="mb-3">
                    <label for="kemasan" class="form-label">Kemasan</label>
                    <input type="text" id="kemasan" name="kemasan" class="form-control" placeholder="Kemasan"
                           value="<?= isset($obatData) ? $obatData['kemasan'] : ''; ?>" required>
                </div>

                <div class="mb-3">
                    <label for="harga" class="form-label">Harga</label>
                    <input type="number" id="harga" name="harga" class="form-control" placeholder="Harga"
                           value="<?= isset($obatData) ? $obatData['harga'] : ''; ?>" required>
                </div>
                
                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary me-2 mr-2"><?= isset($obatData) ? 'Update' : 'Simpan'; ?></button>
                    <?php if (isset($obatData)): ?>
                        <a href="/admin/obat" class="btn btn-secondary">Batal</a>
                    <?php endif; ?>
                </div>
            </form>
        </div>
    </div>

    <!-- Table Card -->
    <div class="card shadow">
        <div class="card-header bg-success text-white">
            <h5 class="mb-0"><i class="fas fa-table"></i> Data Obat</h5>
        </div>
        <div class="card-body">
            <table class="table table-hover table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th>Nama Obat</th>
                        <th>Kemasan</th>
                        <th>Harga</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($obat) && count($obat) > 0): ?>
                        <?php foreach ($obat as $index => $row): ?>
                            <tr>
                                <td><?= $index + 1 ?></td>
                                <td><?= $row['nama_obat'] ?></td>
                                <td><?= $row['kemasan'] ?></td>
                                <td>Rp. <?= number_format($row['harga'], 0, ',', '.') ?></td>
                                <td>
                                    <a href="/admin/obat/edit/<?= $row['obat_id'] ?>" class="btn btn-success btn-sm">Edit</a>
                                    <a href="/admin/obat/delete/<?= $row['obat_id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?');">Hapus</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="text-center text-muted">Tidak ada data</td>
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
