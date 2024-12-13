<h3 class="mb-4 text-center"><?= isset($obatData) ? 'Edit Obat' : 'Mengelola Obat'; ?></h3>

<div class="container">
    <!-- Form Input -->
    <form action="<?= isset($obatData) ? '/admin/obat/update/' . $obatData['obat_id'] : '/admin/obat/save'; ?>" method="post" class="mb-4">
        <div class="col-md-12 mb-3">
            <label for="nama_obat" class="form-label">Nama Obat</label>
            <input type="text" id="nama_obat" name="nama_obat" class="form-control" placeholder="Nama Obat"
                   value="<?= isset($obatData) ? $obatData['nama_obat'] : ''; ?>" required>
        </div>
        
        <div class="col-md-12 mb-3">
            <label for="kemasan" class="form-label">Kemasan</label>
            <input type="text" id="kemasan" name="kemasan" class="form-control" placeholder="Kemasan"
                   value="<?= isset($obatData) ? $obatData['kemasan'] : ''; ?>" required>
        </div>

        <div class="col-md-12 mb-3">
            <label for="harga" class="form-label">Harga</label>
            <input type="number" id="harga" name="harga" class="form-control" placeholder="Harga"
                   value="<?= isset($obatData) ? $obatData['harga'] : ''; ?>" required>
        </div>
        
        <button type="submit" class="btn btn-primary mb-3"><?= isset($obatData) ? 'Update' : 'Simpan'; ?></button>
        <?php if (isset($obatData)): ?>
            <a href="/admin/obat" class="btn btn-secondary mb-3">Batal</a>
        <?php endif; ?>
    </form>

    <!-- Tabel Data Obat -->
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Obat</th>
                <th>Kemasan</th>
                <th>Harga</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($obat) > 0): ?>
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
                    <td colspan="5" class="text-center">Tidak ada data</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
