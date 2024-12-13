<h3 class="mb-4 text-center"><?= isset($poliData) ? 'Edit Poli' : 'Mengelola Poli'; ?></h3>

<div class="container">
    <!-- Form Input -->
    <form action="<?= isset($poliData) ? '/admin/poli/update/' . $poliData['poli_id'] : '/admin/poli/save'; ?>" method="post" class="mb-4">
        <div class="col-md-12 mb-3">
            <label for="nama_poli" class="form-label">Nama Poli</label>
            <input type="text" id="nama_poli" name="nama_poli" class="form-control" placeholder="Nama Poli" 
                   value="<?= isset($poliData) ? $poliData['nama_poli'] : ''; ?>" required>
        </div>
        
        <div class="col-md-12 mb-3">
            <label for="keterangan" class="form-label">Keterangan</label>
            <input type="text" id="keterangan" name="keterangan" class="form-control" placeholder="Keterangan" 
                   value="<?= isset($poliData) ? $poliData['keterangan'] : ''; ?>" required>
        </div>
        
        <button type="submit" class="btn btn-primary mb-3"><?= isset($poliData) ? 'Update' : 'Simpan'; ?></button>
        <?php if (isset($poliData)): ?>
            <a href="/admin/poli" class="btn btn-secondary mb-3">Batal</a>
        <?php endif; ?>
    </form>

    <!-- Tabel Data Poli -->
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Poli</th>
                <th>Keterangan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($poli) > 0): ?>
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
                    <td colspan="4" class="text-center">Tidak ada data</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
