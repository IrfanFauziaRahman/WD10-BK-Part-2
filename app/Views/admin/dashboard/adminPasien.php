<div class="container mt-1">
    <!-- Heading -->
    <div class="text-center mb-3">
        <h2 class="fw-bold text-primary">
            <i class="fas fa-procedures"></i>
            <?= isset($pasienData) ? 'Edit Pasien' : 'Pasien'; ?>
        </h2>
        <p class="text-muted">Gunakan form di bawah ini untuk menambahkan atau mengedit data pasien.</p>
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
            <h5 class="mb-0"><?= isset($pasienData) ? 'Edit Data Pasien' : 'Tambah Data Pasien'; ?></h5>
        </div>
        <div class="card-body">
            <form action="<?= isset($pasienData) ? '/admin/pasien/update/' . $pasienData['pasien_id'] : '/admin/pasien/save'; ?>" method="post">
                <!-- CSRF Token -->
                <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>">

                <div class="mb-3">
                    <label for="nama_pasien" class="form-label">Nama Pasien</label>
                    <input type="text" id="nama_pasien" name="nama_pasien" class="form-control" placeholder="Nama Pasien"
                        value="<?= isset($pasienData) ? $pasienData['nama_pasien'] : ''; ?>" required>
                </div>

                <div class="mb-3">
                    <label for="alamat" class="form-label">Alamat</label>
                    <input type="text" id="alamat" name="alamat" class="form-control" placeholder="Alamat"
                        value="<?= isset($pasienData) ? $pasienData['alamat'] : ''; ?>" required>
                </div>

                <div class="mb-3">
                    <label for="no_ktp" class="form-label">Nomor KTP</label>
                    <input type="number" id="no_ktp" name="no_ktp" class="form-control" placeholder="Nomor KTP"
                        value="<?= isset($pasienData) ? $pasienData['no_ktp'] : ''; ?>" required>
                </div>

                <div class="mb-3">
                    <label for="no_hp" class="form-label">Nomor HP</label>
                    <input type="number" id="no_hp" name="no_hp" class="form-control" placeholder="Nomor HP"
                        value="<?= isset($pasienData) ? $pasienData['no_hp'] : ''; ?>" required>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" id="email" name="email" class="form-control" placeholder="Email" 
                        value="<?= isset($userData['email']) ? $userData['email'] : ''; ?>" required>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">
                        <?= isset($pasienData) ? 'Password (Isi jika ingin mengubah)' : 'Password'; ?>
                    </label>
                    <input type="password" id="password" name="password" class="form-control" placeholder="Password (Minimal 6 Karakter)">
                </div>

                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary me-2 mr-2"><?= isset($pasienData) ? 'Update' : 'Simpan'; ?></button>
                    <?php if (isset($pasienData)): ?>
                        <a href="/admin/pasien" class="btn btn-secondary">Batal</a>
                    <?php endif; ?>
                </div>
            </form>
        </div>
    </div>

    <!-- Table Card -->
    <div class="card shadow">
        <div class="card-header bg-success text-white">
            <h5 class="mb-0"><i class="fas fa-table"></i> Data Pasien</h5>
        </div>
        <div class="card-body">
            <table class="table table-hover table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th>Nama Pasien</th>
                        <th>Email</th>
                        <th>Alamat</th>
                        <th>No. KTP</th>
                        <th>No. HP</th>
                        <th>No. RM</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($pasien) && count($pasien) > 0): ?>
                        <?php foreach ($pasien as $index => $row): ?>
                            <tr>
                                <td><?= $index + 1 ?></td>
                                <td><?= esc($row['nama_pasien']) ?></td>
                                <td><?= esc($row['email']) ?></td>
                                <td><?= esc($row['alamat']) ?></td>
                                <td><?= esc($row['no_ktp']) ?></td>
                                <td><?= esc($row['no_hp']) ?></td>
                                <td><?= esc($row['no_rm']) ?></td>
                                <td>
                                    <a href="/admin/pasien/edit/<?= $row['pasien_id'] ?>" class="btn btn-success btn-sm">Edit</a>
                                    <a href="/admin/pasien/delete/<?= $row['pasien_id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?');">Hapus</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="8" class="text-center text-muted">Tidak ada data</td>
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