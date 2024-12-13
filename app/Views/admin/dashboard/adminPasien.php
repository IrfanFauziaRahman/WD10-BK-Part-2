<h3 class="mb-4 text-center"><?= isset($pasienData) ? 'Edit Pasien' : 'Mengelola Data Pasien'; ?></h3>

<!-- JavaScript untuk menghilangkan notifikasi setelah 5 detik -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
        setTimeout(function () {
            const alerts = document.querySelectorAll(".alert");
            alerts.forEach(alert => alert.style.display = "none");
        }, 5000); // 5000 ms = 5 detik
    });
</script>

<div class="container">
    <?php if (session()->getFlashdata('error')) : ?>
        <div class="alert alert-danger">
            <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('success')) : ?>
        <div class="alert alert-success">
            <?= session()->getFlashdata('success') ?>
        </div>
    <?php endif; ?>

    <!-- Form Input -->
    <form action="<?= isset($pasienData) ? '/admin/pasien/update/' . $pasienData['pasien_id'] : '/admin/pasien/save'; ?>" method="post" class="mb-4">
        <div class="col-md-12 mb-3">
            <label for="nama_pasien" class="form-label">Nama Pasien</label>
            <input type="text" id="nama_pasien" name="nama_pasien" class="form-control" placeholder="Nama Pasien"value="<?= isset($pasienData) ? $pasienData['nama_pasien'] : ''; ?>" required>
        </div>

        <div class="col-md-12 mb-3">
            <label for="alamat" class="form-label">Alamat</label>
            <input type="text" 
                   id="alamat" 
                   name="alamat" 
                   class="form-control" 
                   placeholder="Alamat"
                   value="<?= isset($pasienData) ? $pasienData['alamat'] : ''; ?>" 
                   required>
        </div>

        <div class="col-md-12 mb-3">
            <label for="no_ktp" class="form-label">Nomor KTP</label>
            <input type="number" 
                   id="no_ktp" 
                   name="no_ktp" 
                   class="form-control" 
                   placeholder="Nomor KTP"
                   value="<?= isset($pasienData) ? $pasienData['no_ktp'] : ''; ?>" 
                   required>
        </div>

        <div class="col-md-12 mb-3">
            <label for="no_hp" class="form-label">Nomor HP</label>
            <input type="number" 
                   id="no_hp" 
                   name="no_hp" 
                   class="form-control" 
                   placeholder="Nomor HP"
                   value="<?= isset($pasienData) ? $pasienData['no_hp'] : ''; ?>" 
                   required>
        </div>

        <div class="col-md-12 mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" 
                   id="email" 
                   name="email" 
                   class="form-control" 
                   placeholder="Email"
                   value="<?= isset($userData) ? $userData['email'] : ''; ?>" 
                   required>
        </div>

        <div class="col-md-12 mb-3">
            <label for="password" class="form-label">
                Password <?= isset($pasienData) ? '(Isi hanya jika ingin mengubah)' : ''; ?>
            </label>
            <input type="password" 
                   id="password" 
                   name="password" 
                   class="form-control" 
                   placeholder="Password"
                   <?= !isset($pasienData) ? 'required' : ''; ?>>
        </div>

        <button type="submit" class="btn btn-primary">
            <?= isset($pasienData) ? 'Update' : 'Simpan'; ?>
        </button>
        <?php if (isset($pasienData)): ?>
            <a href="/admin/pasien" class="btn btn-secondary">Batal</a>
        <?php endif; ?>
    </form>

    <!-- Tabel Data Pasien -->
    <h4 class="mb-3">Daftar Pasien</h4>
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead>
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
                <?php if (isset($pasien) && count($pasien) > 0): ?>
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
                                <a href="/admin/pasien/edit/<?= $row['pasien_id'] ?>" 
                                   class="btn btn-success btn-sm">Edit</a>
                                <a href="/admin/pasien/delete/<?= $row['pasien_id'] ?>" 
                                   class="btn btn-danger btn-sm" 
                                   onclick="return confirm('Yakin ingin menghapus?');">Hapus</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="8" class="text-center">Tidak ada data</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>